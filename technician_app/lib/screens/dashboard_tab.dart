import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/job.dart';
import '../models/user.dart';
import '../core/theme.dart';
import '../core/navigation_helper.dart';
import 'job_details_screen.dart';

class DashboardTab extends StatefulWidget {
  final VoidCallback onNavigateToJobs;
  const DashboardTab({super.key, required this.onNavigateToJobs});

  @override
  State<DashboardTab> createState() => _DashboardTabState();
}

class _DashboardTabState extends State<DashboardTab> {
  User? _user;
  List<Job> _jobs = [];
  bool _isLoading = true;
  String? _errorMessage;

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  Future<void> _loadData() async {
    setState(() {
      _isLoading = true;
      _errorMessage = null;
    });

    try {
      final user = await ApiService.getCachedUser();
      final jobs = await ApiService.getAssignedJobs();
      setState(() {
        _user = user;
        _jobs = jobs;
        _isLoading = false;
      });
    } catch (e) {
      setState(() {
        _errorMessage = 'Failed to load dashboard data: $e';
        _isLoading = false;
      });
    }
  }

  int get _totalCount => _jobs.length;
  int get _pendingCount => _jobs.where((j) => j.status.toLowerCase() == 'pending').length;
  int get _activeCount => _jobs.where((j) => 
    j.status.toLowerCase() == 'in-route' || j.status.toLowerCase() == 'in-progress'
  ).length;
  int get _completedCount => _jobs.where((j) => j.status.toLowerCase() == 'completed').length;

  Job? get _activeJob {
    final active = _jobs.where((j) => 
      j.status.toLowerCase() == 'in-progress' || j.status.toLowerCase() == 'in-route'
    ).toList();
    return active.isNotEmpty ? active.first : null;
  }

  @override
  Widget build(BuildContext context) {
    return RefreshIndicator(
      onRefresh: _loadData,
      color: AppTheme.secondaryAccent,
      backgroundColor: AppTheme.surface,
      child: _isLoading
          ? const Center(
              child: CircularProgressIndicator(color: AppTheme.secondaryAccent),
            )
          : _errorMessage != null
              ? Center(
                  child: Padding(
                    padding: const EdgeInsets.all(24.0),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Icon(Icons.error_outline, size: 60, color: AppTheme.error),
                        const SizedBox(height: 16),
                        Text(_errorMessage!, textAlign: TextAlign.center),
                        const SizedBox(height: 24),
                        ElevatedButton(
                          onPressed: _loadData,
                          child: const Text('Try Again'),
                        ),
                      ],
                    ),
                  ),
                )
              : SingleChildScrollView(
                  physics: const AlwaysScrollableScrollPhysics(),
                  padding: const EdgeInsets.all(20.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      // Greeting Header
                      Row(
                        children: [
                          CircleAvatar(
                            radius: 28,
                            backgroundColor: AppTheme.secondary.withValues(alpha: 0.2),
                            child: const Icon(
                              Icons.engineering,
                              color: AppTheme.secondaryAccent,
                              size: 32,
                            ),
                          ),
                          const SizedBox(width: 16),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  'Welcome back,',
                                  style: TextStyle(
                                    fontSize: 14,
                                    color: AppTheme.textOutline,
                                  ),
                                ),
                                Text(
                                  _user?.name ?? 'Technician',
                                  style: const TextStyle(
                                    fontSize: 22,
                                    fontWeight: FontWeight.bold,
                                    color: Colors.white,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 24),

                      // Section Title
                      const Text(
                        'TODAY\'S PERFORMANCE',
                        style: TextStyle(
                          fontSize: 12,
                          fontWeight: FontWeight.bold,
                          letterSpacing: 1.5,
                          color: AppTheme.textOutline,
                        ),
                      ),
                      const SizedBox(height: 12),

                      // Stats Grid
                      GridView.count(
                        crossAxisCount: 2,
                        shrinkWrap: true,
                        physics: const NeverScrollableScrollPhysics(),
                        crossAxisSpacing: 16,
                        mainAxisSpacing: 16,
                        childAspectRatio: 1.4,
                        children: [
                          _buildStatCard(
                            'Assigned Jobs',
                            _totalCount.toString(),
                            Icons.assignment_outlined,
                            AppTheme.secondaryAccent,
                          ),
                          _buildStatCard(
                            'Active Jobs',
                            _activeCount.toString(),
                            Icons.play_circle_outline,
                            Colors.orange,
                          ),
                          _buildStatCard(
                            'Pending',
                            _pendingCount.toString(),
                            Icons.hourglass_empty_outlined,
                            Colors.blue,
                          ),
                          _buildStatCard(
                            'Completed',
                            _completedCount.toString(),
                            Icons.check_circle_outline,
                            Colors.green,
                          ),
                        ],
                      ),
                      const SizedBox(height: 24),

                      // Active or Upcoming Job Card
                      if (_activeJob != null) ...[
                        const Text(
                          'ACTIVE DISPATCH ORDER',
                          style: TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.bold,
                            letterSpacing: 1.5,
                            color: AppTheme.textOutline,
                          ),
                        ),
                        const SizedBox(height: 12),
                        _buildActiveJobCard(_activeJob!),
                      ] else if (_nextPendingJob != null) ...[
                        const Text(
                          'UPCOMING DISPATCH ORDER',
                          style: TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.bold,
                            letterSpacing: 1.5,
                            color: AppTheme.textOutline,
                          ),
                        ),
                        const SizedBox(height: 12),
                        _buildActiveJobCard(_nextPendingJob!),
                      ] else ...[
                        _buildNoActiveJobWidget(),
                      ],
                    ],
                  ),
                ),
    );
  }

  Job? get _nextPendingJob {
    final pending = _jobs.where((j) => j.status.toLowerCase() == 'pending').toList();
    return pending.isNotEmpty ? pending.first : null;
  }

  Future<void> _handleStartRoute(Job job) async {
    if (job.status.toLowerCase() == 'pending') {
      setState(() {
        _isLoading = true;
      });
      try {
        final result = await ApiService.startRoute(job.id);
        if (result['success']) {
          if (mounted) {
            await NavigationHelper.launchGoogleMaps(
              context,
              latitude: job.latitude,
              longitude: job.longitude,
            );
          }
        } else {
          if (mounted) {
            _showErrorDialog(result['message']);
          }
        }
      } catch (e) {
        if (mounted) {
          _showErrorDialog('Connection error: $e');
        }
      } finally {
        _loadData();
      }
    } else {
      await NavigationHelper.launchGoogleMaps(
        context,
        latitude: job.latitude,
        longitude: job.longitude,
      );
    }
  }

  void _showErrorDialog(String message) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Error'),
        content: Text(message),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('OK'),
          ),
        ],
      ),
    );
  }

  Widget _buildStatCard(String title, String value, IconData icon, Color color) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppTheme.surface,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: Colors.white10),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Icon(icon, color: color, size: 24),
              Text(
                value,
                style: const TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                  color: Colors.white,
                ),
              ),
            ],
          ),
          Text(
            title,
            style: const TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.w600,
              color: AppTheme.textOutline,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildActiveJobCard(Job job) {
    final status = job.status.toLowerCase();
    final bool inProgress = status == 'in-progress';
    final bool inRoute = status == 'in-route';
    final bool isPending = status == 'pending';

    final Color statusColor = inProgress
        ? Colors.green
        : inRoute
            ? Colors.orange
            : Colors.blue;

    final IconData statusIcon = inProgress
        ? Icons.engineering
        : inRoute
            ? Icons.directions_car
            : Icons.hourglass_top;

    return Container(
      width: double.infinity,
      decoration: BoxDecoration(
        gradient: LinearGradient(
          colors: [
            (isPending ? Colors.blue : AppTheme.secondary).withValues(alpha: 0.25),
            AppTheme.surface,
          ],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(
          color: (isPending ? Colors.blue : AppTheme.secondaryAccent).withValues(alpha: 0.3),
          width: 1.5,
        ),
        boxShadow: [
          BoxShadow(
            color: (isPending ? Colors.blue : AppTheme.secondaryAccent).withValues(alpha: 0.05),
            blurRadius: 10,
            spreadRadius: 2,
          ),
        ],
      ),
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                decoration: BoxDecoration(
                  color: statusColor.withValues(alpha: 0.15),
                  borderRadius: BorderRadius.circular(8),
                  border: Border.all(color: statusColor.withValues(alpha: 0.4)),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Icon(
                      statusIcon,
                      size: 14,
                      color: statusColor,
                    ),
                    const SizedBox(width: 4),
                    Text(
                      job.status.toUpperCase(),
                      style: TextStyle(
                        fontSize: 11,
                        fontWeight: FontWeight.bold,
                        color: statusColor,
                      ),
                    ),
                  ],
                ),
              ),
              Text(
                '#JOB-${job.id}',
                style: TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.bold,
                  color: isPending ? Colors.blue : AppTheme.secondaryAccent,
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          Text(
            job.clientName,
            style: const TextStyle(
              fontSize: 20,
              fontWeight: FontWeight.bold,
              color: Colors.white,
            ),
          ),
          const SizedBox(height: 8),
          Row(
            children: [
              const Icon(Icons.location_on, size: 16, color: AppTheme.textOutline),
              const SizedBox(width: 8),
              Expanded(
                child: Text(
                  job.serviceAddress,
                  style: const TextStyle(color: AppTheme.textOutline, fontSize: 13),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          const Divider(color: Colors.white10),
          const SizedBox(height: 8),
          const Text(
            'REPORTED ISSUE:',
            style: TextStyle(
              fontSize: 10,
              fontWeight: FontWeight.bold,
              color: AppTheme.textOutline,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            job.issueDescription,
            style: const TextStyle(color: Colors.white70, fontSize: 13),
            maxLines: 2,
            overflow: TextOverflow.ellipsis,
          ),
          const SizedBox(height: 20),
          SizedBox(
            width: double.infinity,
            child: ElevatedButton(
              onPressed: () async {
                if (inProgress) {
                  await Navigator.of(context).push(
                    MaterialPageRoute(builder: (_) => JobDetailsScreen(job: job)),
                  );
                  _loadData();
                } else {
                  await _handleStartRoute(job);
                }
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: isPending ? Colors.blue : AppTheme.secondaryAccent,
                foregroundColor: isPending ? Colors.white : Colors.black,
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    inProgress
                        ? 'Open Terminal / Complete Job'
                        : inRoute
                            ? 'Resume Route Navigation'
                            : 'Start Route Navigation',
                  ),
                  const SizedBox(width: 8),
                  const Icon(Icons.arrow_forward, size: 16),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildNoActiveJobWidget() {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(
        color: AppTheme.surface,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: Colors.white10),
      ),
      padding: const EdgeInsets.all(24),
      child: Column(
        children: [
          Icon(
            Icons.check_circle_outline,
            size: 48,
            color: AppTheme.secondaryAccent.withValues(alpha: 0.6),
          ),
          const SizedBox(height: 16),
          const Text(
            'All Caught Up!',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.bold,
              color: Colors.white,
            ),
          ),
          const SizedBox(height: 8),
          const Text(
            'No dispatch orders are currently active or in-route.',
            textAlign: TextAlign.center,
            style: TextStyle(color: AppTheme.textOutline, fontSize: 13),
          ),
          const SizedBox(height: 20),
          OutlinedButton(
            onPressed: widget.onNavigateToJobs,
            style: OutlinedButton.styleFrom(
              side: const BorderSide(color: AppTheme.secondaryAccent),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
            ),
            child: const Text(
              'Browse Assigned Jobs',
              style: TextStyle(color: AppTheme.secondaryAccent),
            ),
          ),
        ],
      ),
    );
  }
}
