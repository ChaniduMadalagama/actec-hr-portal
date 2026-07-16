import 'dart:ui';
import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import '../models/job.dart';
import '../services/api_service.dart';
import '../core/theme.dart';
import '../core/navigation_helper.dart';

class JobDetailsScreen extends StatefulWidget {
  final Job job;
  const JobDetailsScreen({super.key, required this.job});

  @override
  State<JobDetailsScreen> createState() => _JobDetailsScreenState();
}

class _JobDetailsScreenState extends State<JobDetailsScreen> {
  late Job _job;
  bool _isLoading = false;
  String? _statusMessage;

  @override
  void initState() {
    super.initState();
    _job = widget.job;
  }

  Future<Position?> _getCurrentLocation() async {
    try {
      bool serviceEnabled = await Geolocator.isLocationServiceEnabled();
      if (!serviceEnabled) {
        _showError('Location services are disabled on your device.');
        return null;
      }

      LocationPermission permission = await Geolocator.checkPermission();
      if (permission == LocationPermission.denied) {
        permission = await Geolocator.requestPermission();
        if (permission == LocationPermission.denied) {
          _showError('Location permission was denied.');
          return null;
        }
      }

      if (permission == LocationPermission.deniedForever) {
        _showError('Location permission is permanently denied. Please enable it in system settings.');
        return null;
      }

      return await Geolocator.getCurrentPosition(
        locationSettings: const LocationSettings(accuracy: LocationAccuracy.high),
      );
    } catch (e) {
      _showError('Error retrieving location: $e');
      return null;
    }
  }

  void _showError(String message) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Row(
          children: [
            Icon(Icons.warning_amber_rounded, color: AppTheme.error),
            SizedBox(width: 8),
            Text('Action Failed'),
          ],
        ),
        content: Text(message),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('OK', style: TextStyle(color: AppTheme.secondaryAccent)),
          ),
        ],
      ),
    );
  }

  Future<void> _handleAction() async {
    setState(() {
      _isLoading = true;
      _statusMessage = null;
    });

    try {
      if (_job.status.toLowerCase() == 'pending') {
        // Start Route API
        final result = await ApiService.startRoute(_job.id);
        if (result['success']) {
          setState(() {
            _job = Job(
              id: _job.id,
              clientName: _job.clientName,
              clientPhone: _job.clientPhone,
              serviceAddress: _job.serviceAddress,
              latitude: _job.latitude,
              longitude: _job.longitude,
              issueDescription: _job.issueDescription,
              status: 'in-route',
              assignedTo: _job.assignedTo,
              scheduledAt: _job.scheduledAt,
            );
          });
          if (!mounted) return;
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text('Route started successfully!'),
              backgroundColor: Colors.green,
            ),
          );

          // Launch Google Maps navigation automatically
          await NavigationHelper.launchGoogleMaps(
            context,
            latitude: _job.latitude,
            longitude: _job.longitude,
          );
        } else {
          _showError(result['message']);
        }
      } else if (_job.status.toLowerCase() == 'in-route') {
        // Get GPS
        setState(() {
          _statusMessage = "Acquiring GPS location...";
        });
        final position = await _getCurrentLocation();
        if (position == null) {
          setState(() => _isLoading = false);
          return;
        }

        // Check In API
        setState(() {
          _statusMessage = "Sending check-in logs...";
        });
        final result = await ApiService.checkIn(_job.id, position.latitude, position.longitude);
        if (result['success']) {
          setState(() {
            _job = Job(
              id: _job.id,
              clientName: _job.clientName,
              clientPhone: _job.clientPhone,
              serviceAddress: _job.serviceAddress,
              latitude: _job.latitude,
              longitude: _job.longitude,
              issueDescription: _job.issueDescription,
              status: 'in-progress',
              assignedTo: _job.assignedTo,
              scheduledAt: _job.scheduledAt,
            );
          });
          if (!mounted) return;
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text('Successfully checked in!'),
              backgroundColor: Colors.green,
            ),
          );
        } else {
          _showError(result['message']);
        }
      } else if (_job.status.toLowerCase() == 'in-progress') {
        // Get GPS
        setState(() {
          _statusMessage = "Acquiring GPS location...";
        });
        final position = await _getCurrentLocation();
        if (position == null) {
          setState(() => _isLoading = false);
          return;
        }

        // Check Out API
        setState(() {
          _statusMessage = "Sending checkout logs...";
        });
        final result = await ApiService.checkOut(_job.id, position.latitude, position.longitude);
        if (result['success']) {
          setState(() {
            _job = Job(
              id: _job.id,
              clientName: _job.clientName,
              clientPhone: _job.clientPhone,
              serviceAddress: _job.serviceAddress,
              latitude: _job.latitude,
              longitude: _job.longitude,
              issueDescription: _job.issueDescription,
              status: 'completed',
              assignedTo: _job.assignedTo,
              scheduledAt: _job.scheduledAt,
            );
          });
          if (!mounted) return;
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text('Successfully checked out! Job completed.'),
              backgroundColor: Colors.green,
            ),
          );
        } else {
          _showError(result['message']);
        }
      }
    } catch (e) {
      _showError('Unexpected error: $e');
    } finally {
      setState(() {
        _isLoading = false;
        _statusMessage = null;
      });
    }
  }

  Color _getStatusColor(String status) {
    switch (status.toLowerCase()) {
      case 'pending':
        return Colors.blue;
      case 'in-route':
        return Colors.orange;
      case 'in-progress':
        return Colors.green;
      case 'completed':
        return Colors.grey;
      default:
        return Colors.white;
    }
  }

  Widget _buildActionButton() {
    final status = _job.status.toLowerCase();
    String label = '';
    IconData icon = Icons.play_arrow;
    Color buttonColor = AppTheme.secondary;

    if (status == 'pending') {
      label = 'Start Route';
      icon = Icons.directions_car;
      buttonColor = Colors.blue;
    } else if (status == 'in-route') {
      label = 'Check In';
      icon = Icons.location_on;
      buttonColor = Colors.orange;
    } else if (status == 'in-progress') {
      label = 'Check Out';
      icon = Icons.check_circle_outline;
      buttonColor = Colors.green;
    } else {
      return Container(
        height: 56,
        decoration: BoxDecoration(
          color: Colors.white12,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: Colors.white24),
        ),
        child: const Center(
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(Icons.verified, color: Colors.green),
              SizedBox(width: 8),
              Text(
                'Job Completed Successfully',
                style: TextStyle(color: Colors.white70, fontWeight: FontWeight.bold),
              ),
            ],
          ),
        ),
      );
    }

    return SizedBox(
      height: 56,
      child: ElevatedButton.icon(
        onPressed: _isLoading ? null : _handleAction,
        style: ElevatedButton.styleFrom(
          backgroundColor: buttonColor,
          shadowColor: buttonColor.withValues(alpha: 0.5),
        ),
        icon: _isLoading
            ? const SizedBox(
                width: 20,
                height: 20,
                child: CircularProgressIndicator(
                  strokeWidth: 2,
                  valueColor: AlwaysStoppedAnimation<Color>(Colors.white),
                ),
              )
            : Icon(icon),
        label: Text(_isLoading ? (_statusMessage ?? 'Processing...') : label),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.background,
      appBar: AppBar(
        title: Text('Job details: #JOB-${_job.id}'),
        backgroundColor: AppTheme.surface,
        elevation: 0,
      ),
      body: Stack(
        children: [
          // Background ambient gradient
          Positioned(
            top: -50,
            right: -50,
            child: Container(
              width: 250,
              height: 250,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: _getStatusColor(_job.status).withValues(alpha: 0.15),
              ),
            ),
          ),
          BackdropFilter(
            filter: ImageFilter.blur(sigmaX: 40, sigmaY: 40),
            child: Container(color: Colors.transparent),
          ),
          SingleChildScrollView(
            padding: const EdgeInsets.all(24.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                // Glassmorphism Card
                Container(
                  padding: const EdgeInsets.all(24),
                  decoration: BoxDecoration(
                    color: AppTheme.surface.withValues(alpha: 0.6),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: Colors.white10),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          const Text(
                            'ORDER INFORMATION',
                            style: TextStyle(
                              fontSize: 12,
                              fontWeight: FontWeight.bold,
                              color: AppTheme.textOutline,
                              letterSpacing: 1.2,
                            ),
                          ),
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                            decoration: BoxDecoration(
                              color: _getStatusColor(_job.status).withValues(alpha: 0.1),
                              borderRadius: BorderRadius.circular(12),
                              border: Border.all(
                                color: _getStatusColor(_job.status).withValues(alpha: 0.5),
                              ),
                            ),
                            child: Text(
                              _job.status.toUpperCase(),
                              style: TextStyle(
                                fontSize: 11,
                                fontWeight: FontWeight.bold,
                                color: _getStatusColor(_job.status),
                              ),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 20),
                      Text(
                        _job.clientName,
                        style: const TextStyle(
                          fontSize: 24,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                        ),
                      ),
                      const SizedBox(height: 16),
                      const Divider(color: Colors.white10),
                      const SizedBox(height: 16),
                      Row(
                        children: [
                          const Icon(Icons.phone, color: AppTheme.secondaryAccent, size: 20),
                          const SizedBox(width: 12),
                          Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              const Text('CLIENT CONTACT', style: TextStyle(fontSize: 10, color: AppTheme.textOutline)),
                              const SizedBox(height: 2),
                              Text(_job.clientPhone, style: const TextStyle(color: Colors.white, fontSize: 16)),
                            ],
                          )
                        ],
                      ),
                      const SizedBox(height: 16),
                      InkWell(
                        onTap: () => NavigationHelper.launchGoogleMaps(
                          context,
                          latitude: _job.latitude,
                          longitude: _job.longitude,
                        ),
                        borderRadius: BorderRadius.circular(8),
                        child: Padding(
                          padding: const EdgeInsets.symmetric(vertical: 4.0),
                          child: Row(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              const Icon(Icons.location_on, color: AppTheme.secondaryAccent, size: 20),
                              const SizedBox(width: 12),
                              Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    const Row(
                                      children: [
                                        Text('SERVICE ADDRESS', style: TextStyle(fontSize: 10, color: AppTheme.textOutline)),
                                        SizedBox(width: 8),
                                        Icon(Icons.directions, size: 12, color: AppTheme.secondaryAccent),
                                      ],
                                    ),
                                    const SizedBox(height: 2),
                                    Text(_job.serviceAddress, style: const TextStyle(color: Colors.white, fontSize: 16)),
                                  ],
                                ),
                              )
                            ],
                          ),
                        ),
                      ),
                      const SizedBox(height: 16),
                      Row(
                        children: [
                          const Icon(Icons.gps_fixed, color: AppTheme.secondaryAccent, size: 20),
                          const SizedBox(width: 12),
                          Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              const Text('GPS TARGET COORDINATES', style: TextStyle(fontSize: 10, color: AppTheme.textOutline)),
                              const SizedBox(height: 2),
                              Text('${_job.latitude.toStringAsFixed(6)}, ${_job.longitude.toStringAsFixed(6)}',
                                  style: const TextStyle(color: Colors.white, fontSize: 16)),
                            ],
                          )
                        ],
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 20),
                
                // Issue Description Card
                if (_job.issueDescription.isNotEmpty) ...[
                  Container(
                    padding: const EdgeInsets.all(24),
                    decoration: BoxDecoration(
                      color: AppTheme.surface.withValues(alpha: 0.6),
                      borderRadius: BorderRadius.circular(20),
                      border: Border.all(color: Colors.white10),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text(
                          'AC ISSUE DESCRIPTION',
                          style: TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.bold,
                            color: AppTheme.textOutline,
                            letterSpacing: 1.2,
                          ),
                        ),
                        const SizedBox(height: 12),
                        Text(
                          _job.issueDescription,
                          style: const TextStyle(color: Colors.white70, fontSize: 16, height: 1.4),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 20),
                ],

                // Geofence Guidelines Warning
                if (_job.status.toLowerCase() == 'in-route' || _job.status.toLowerCase() == 'in-progress')
                  Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: Colors.amber.withValues(alpha: 0.1),
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(color: Colors.amber.withValues(alpha: 0.3)),
                    ),
                    child: const Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Icon(Icons.info_outline, color: Colors.amber, size: 20),
                        SizedBox(width: 12),
                        Expanded(
                          child: Text(
                            'Geofence Policy: You must be physically present at the client address (within 500 meters) to successfully Check In or Check Out.',
                            style: TextStyle(color: Colors.amber, fontSize: 13, height: 1.3),
                          ),
                        ),
                      ],
                    ),
                  ),
                const SizedBox(height: 40),

                // Main Action Trigger
                _buildActionButton(),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
