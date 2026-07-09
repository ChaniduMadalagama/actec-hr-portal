import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../core/theme.dart';
import '../models/job.dart';
import 'login_screen.dart';

class DashboardScreen extends StatefulWidget {
  const DashboardScreen({super.key});

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  List<Job> _jobs = [];
  bool _isLoading = true;
  String? _errorMessage;

  @override
  void initState() {
    super.initState();
    _fetchJobs();
  }

  Future<void> _fetchJobs() async {
    setState(() {
      _isLoading = true;
      _errorMessage = null;
    });

    try {
      final jobs = await ApiService.getAssignedJobs();
      setState(() {
        _jobs = jobs;
        _isLoading = false;
      });
    } catch (e) {
      setState(() {
        _errorMessage = 'Failed to load jobs: $e';
        _isLoading = false;
      });
    }
  }

  Future<void> _logout(BuildContext context) async {
    await ApiService.logout();
    if (!context.mounted) return;
    
    Navigator.of(context).pushReplacement(
      MaterialPageRoute(builder: (_) => const LoginScreen()),
    );
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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.background,
      appBar: AppBar(
        title: const Text(
          'LogiFlow Dispatch',
          style: TextStyle(letterSpacing: 1.2, fontWeight: FontWeight.bold),
        ),
        backgroundColor: AppTheme.surface,
        elevation: 0,
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh, color: AppTheme.secondaryAccent),
            onPressed: _fetchJobs,
          ),
          IconButton(
            icon: const Icon(Icons.logout, color: AppTheme.error),
            onPressed: () => _logout(context),
          ),
        ],
      ),
      body: RefreshIndicator(
        onRefresh: _fetchJobs,
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
                            onPressed: _fetchJobs,
                            child: const Text('Try Again'),
                          ),
                        ],
                      ),
                    ),
                  )
                : _jobs.isEmpty
                    ? Center(
                        child: SingleChildScrollView(
                          physics: const AlwaysScrollableScrollPhysics(),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Icon(
                                Icons.engineering_outlined,
                                size: 80,
                                color: AppTheme.secondaryAccent.withValues(alpha: 0.4),
                              ),
                              const SizedBox(height: 20),
                              const Text(
                                'Technician Dashboard',
                                style: TextStyle(
                                  fontSize: 22,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                ),
                              ),
                              const SizedBox(height: 10),
                              const Text(
                                'Awaiting dispatch orders...',
                                style: TextStyle(color: AppTheme.textOutline),
                              ),
                              const SizedBox(height: 20),
                              ElevatedButton(
                                onPressed: _fetchJobs,
                                style: ElevatedButton.styleFrom(
                                  backgroundColor: AppTheme.surface,
                                  side: const BorderSide(color: AppTheme.secondaryAccent),
                                ),
                                child: const Text('Refresh Feed'),
                              ),
                            ],
                          ),
                        ),
                      )
                    : ListView.builder(
                        physics: const AlwaysScrollableScrollPhysics(),
                        padding: const EdgeInsets.all(16.0),
                        itemCount: _jobs.length,
                        itemBuilder: (context, index) {
                          final job = _jobs[index];
                          return Card(
                            color: AppTheme.surface,
                            elevation: 4,
                            margin: const EdgeInsets.only(bottom: 16.0),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(16.0),
                              side: const BorderSide(color: Colors.white10),
                            ),
                            child: Padding(
                              padding: const EdgeInsets.all(20.0),
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                    children: [
                                      Text(
                                        '#JOB-${job.id}',
                                        style: const TextStyle(
                                          fontSize: 14,
                                          fontWeight: FontWeight.bold,
                                          color: AppTheme.secondaryAccent,
                                        ),
                                      ),
                                      Container(
                                        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                                        decoration: BoxDecoration(
                                          color: _getStatusColor(job.status).withValues(alpha: 0.1),
                                          borderRadius: BorderRadius.circular(12),
                                          border: Border.all(
                                            color: _getStatusColor(job.status).withValues(alpha: 0.5),
                                          ),
                                        ),
                                        child: Text(
                                          job.status.toUpperCase(),
                                          style: TextStyle(
                                            fontSize: 11,
                                            fontWeight: FontWeight.bold,
                                            color: _getStatusColor(job.status),
                                          ),
                                        ),
                                      ),
                                    ],
                                  ),
                                  const SizedBox(height: 16),
                                  Text(
                                    job.clientName,
                                    style: const TextStyle(
                                      fontSize: 18,
                                      fontWeight: FontWeight.bold,
                                      color: Colors.white,
                                    ),
                                  ),
                                  const SizedBox(height: 8),
                                  Row(
                                    children: [
                                      const Icon(Icons.phone, size: 16, color: AppTheme.textOutline),
                                      const SizedBox(width: 8),
                                      Text(
                                        job.clientPhone,
                                        style: const TextStyle(color: AppTheme.textOutline),
                                      ),
                                    ],
                                  ),
                                  const SizedBox(height: 8),
                                  Row(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      const Icon(Icons.location_on, size: 16, color: AppTheme.textOutline),
                                      const SizedBox(width: 8),
                                      Expanded(
                                        child: Text(
                                          job.serviceAddress,
                                          style: const TextStyle(color: AppTheme.textOutline),
                                        ),
                                      ),
                                    ],
                                  ),
                                  if (job.issueDescription.isNotEmpty) ...[
                                    const SizedBox(height: 12),
                                    const Divider(color: Colors.white10),
                                    const SizedBox(height: 8),
                                    const Text(
                                      'ISSUE DESCRIPTION:',
                                      style: TextStyle(
                                        fontSize: 11,
                                        fontWeight: FontWeight.bold,
                                        color: AppTheme.textOutline,
                                      ),
                                    ),
                                    const SizedBox(height: 4),
                                    Text(
                                      job.issueDescription,
                                      style: const TextStyle(color: Colors.white70),
                                    ),
                                  ],
                                ],
                              ),
                            ),
                          );
                        },
                      ),
      ),
    );
  }
}
