import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/job.dart';
import '../core/theme.dart';
import 'job_details_screen.dart';

class JobsTab extends StatefulWidget {
  const JobsTab({super.key});

  @override
  State<JobsTab> createState() => _JobsTabState();
}

class _JobsTabState extends State<JobsTab> {
  List<Job> _jobs = [];
  bool _isLoading = true;
  String? _errorMessage;
  String _selectedFilter = 'all'; // 'all', 'pending', 'active', 'completed'

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

  List<Job> get _filteredJobs {
    if (_selectedFilter == 'all') return _jobs;
    return _jobs.where((job) {
      final status = job.status.toLowerCase();
      if (_selectedFilter == 'pending') return status == 'pending';
      if (_selectedFilter == 'active') return status == 'in-route' || status == 'in-progress';
      if (_selectedFilter == 'completed') return status == 'completed';
      return true;
    }).toList();
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
    return Column(
      children: [
        // Filter Chips Bar
        SingleChildScrollView(
          scrollDirection: Axis.horizontal,
          padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 12.0),
          child: Row(
            children: [
              _buildFilterChip('All', 'all'),
              const SizedBox(width: 8),
              _buildFilterChip('Pending', 'pending'),
              const SizedBox(width: 8),
              _buildFilterChip('Active', 'active'),
              const SizedBox(width: 8),
              _buildFilterChip('Completed', 'completed'),
            ],
          ),
        ),

        // Main List View
        Expanded(
          child: RefreshIndicator(
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
                    : _filteredJobs.isEmpty
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
                                    'No Jobs Found',
                                    style: TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.bold,
                                      color: Colors.white,
                                    ),
                                  ),
                                  const SizedBox(height: 10),
                                  Text(
                                    'No jobs match the filter "${_selectedFilter.toUpperCase()}".',
                                    style: const TextStyle(color: AppTheme.textOutline),
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
                            padding: const EdgeInsets.symmetric(horizontal: 16.0),
                            itemCount: _filteredJobs.length,
                            itemBuilder: (context, index) {
                              final job = _filteredJobs[index];
                              return InkWell(
                                onTap: () async {
                                  await Navigator.of(context).push(
                                    MaterialPageRoute(
                                      builder: (_) => JobDetailsScreen(job: job),
                                    ),
                                  );
                                  _fetchJobs();
                                },
                                borderRadius: BorderRadius.circular(16.0),
                                child: Card(
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
                                ),
                              );
                            },
                          ),
          ),
        ),
      ],
    );
  }

  Widget _buildFilterChip(String label, String filter) {
    final isSelected = _selectedFilter == filter;
    return ChoiceChip(
      label: Text(label),
      selected: isSelected,
      onSelected: (selected) {
        if (selected) {
          setState(() {
            _selectedFilter = filter;
          });
        }
      },
      selectedColor: AppTheme.secondary.withValues(alpha: 0.3),
      backgroundColor: AppTheme.surface,
      labelStyle: TextStyle(
        color: isSelected ? AppTheme.secondaryAccent : Colors.white70,
        fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
      ),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(20),
        side: BorderSide(
          color: isSelected ? AppTheme.secondaryAccent : Colors.white10,
        ),
      ),
      showCheckmark: false,
    );
  }
}
