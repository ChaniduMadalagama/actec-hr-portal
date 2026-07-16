import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/user.dart';
import '../core/theme.dart';
import 'login_screen.dart';

class MoreTab extends StatefulWidget {
  const MoreTab({super.key});

  @override
  State<MoreTab> createState() => _MoreTabState();
}

class _MoreTabState extends State<MoreTab> {
  User? _user;
  bool _isLoading = true;
  final _serverUrlController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _loadProfile();
  }

  Future<void> _loadProfile() async {
    final user = await ApiService.getCachedUser();
    final currentBaseUrl = await ApiService.baseUrl;
    setState(() {
      _user = user;
      _serverUrlController.text = currentBaseUrl;
      _isLoading = false;
    });
  }

  Future<void> _saveServerUrl() async {
    final cleanUrl = _serverUrlController.text.trim();
    if (cleanUrl.isEmpty) return;

    await ApiService.setBaseUrl(cleanUrl);
    if (!mounted) return;

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('API Server URL updated successfully!'),
        backgroundColor: Colors.green,
        behavior: SnackBarBehavior.floating,
      ),
    );
  }

  Future<void> _logout() async {
    await ApiService.logout();
    if (!mounted) return;

    Navigator.of(context).pushAndRemoveUntil(
      MaterialPageRoute(builder: (_) => const LoginScreen()),
      (route) => false,
    );
  }

  @override
  void dispose() {
    _serverUrlController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Center(
        child: CircularProgressIndicator(color: AppTheme.secondaryAccent),
      );
    }

    return SingleChildScrollView(
      padding: const EdgeInsets.all(20.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Profile Card
          Container(
            width: double.infinity,
            padding: const EdgeInsets.all(20),
            decoration: BoxDecoration(
              color: AppTheme.surface,
              borderRadius: BorderRadius.circular(16),
              border: Border.all(color: Colors.white10),
            ),
            child: Column(
              children: [
                CircleAvatar(
                  radius: 36,
                  backgroundColor: AppTheme.secondaryAccent.withValues(alpha: 0.1),
                  child: const Icon(
                    Icons.person,
                    size: 40,
                    color: AppTheme.secondaryAccent,
                  ),
                ),
                const SizedBox(height: 16),
                Text(
                  _user?.name ?? 'Technician Name',
                  style: const TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.bold,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  '@${_user?.username ?? 'username'}',
                  style: const TextStyle(
                    fontSize: 14,
                    color: AppTheme.textOutline,
                  ),
                ),
                const SizedBox(height: 12),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                  decoration: BoxDecoration(
                    color: AppTheme.secondary.withValues(alpha: 0.2),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: AppTheme.secondary.withValues(alpha: 0.5)),
                  ),
                  child: Text(
                    (_user?.role ?? 'Technician').toUpperCase(),
                    style: const TextStyle(
                      fontSize: 11,
                      fontWeight: FontWeight.bold,
                      color: AppTheme.secondaryAccent,
                    ),
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 24),

          // Details List
          const Text(
            'ACCOUNT INFORMATION',
            style: TextStyle(
              fontSize: 12,
              fontWeight: FontWeight.bold,
              letterSpacing: 1.5,
              color: AppTheme.textOutline,
            ),
          ),
          const SizedBox(height: 10),
          _buildInfoRow('Email Address', _user?.email ?? 'N/A'),
          _buildInfoRow('Current Status', _user?.currentStatus ?? 'N/A'),
          const SizedBox(height: 24),

          // Developer/Admin Configuration
          const Text(
            'NETWORK CONFIGURATION',
            style: TextStyle(
              fontSize: 12,
              fontWeight: FontWeight.bold,
              letterSpacing: 1.5,
              color: AppTheme.textOutline,
            ),
          ),
          const SizedBox(height: 10),
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: AppTheme.surface,
              borderRadius: BorderRadius.circular(16),
              border: Border.all(color: Colors.white10),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                const Text(
                  'API Base URL',
                  style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14),
                ),
                const SizedBox(height: 4),
                const Text(
                  'Change this to target different staging or development environments.',
                  style: TextStyle(color: AppTheme.textOutline, fontSize: 12),
                ),
                const SizedBox(height: 12),
                TextField(
                  controller: _serverUrlController,
                  style: const TextStyle(color: Colors.white, fontSize: 14),
                  decoration: const InputDecoration(
                    hintText: 'http://192.168.1.4:8000/api/v1',
                    contentPadding: EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                  ),
                ),
                const SizedBox(height: 16),
                ElevatedButton(
                  onPressed: _saveServerUrl,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: AppTheme.surface,
                    side: const BorderSide(color: AppTheme.secondaryAccent),
                  ),
                  child: const Text('Save Server Configuration'),
                ),
              ],
            ),
          ),
          const SizedBox(height: 32),

          // Logout Action
          SizedBox(
            width: double.infinity,
            height: 54,
            child: OutlinedButton(
              onPressed: _logout,
              style: OutlinedButton.styleFrom(
                side: const BorderSide(color: AppTheme.error),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
              ),
              child: const Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.logout, color: AppTheme.error),
                  SizedBox(width: 8),
                  Text(
                    'Terminate Session (Logout)',
                    style: TextStyle(color: AppTheme.error, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20),
        ],
      ),
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Container(
      margin: const EdgeInsets.only(bottom: 8),
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
      decoration: BoxDecoration(
        color: AppTheme.surface,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.white10),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(label, style: const TextStyle(color: AppTheme.textOutline, fontSize: 14)),
          Text(value, style: const TextStyle(color: Colors.white, fontWeight: FontWeight.w600, fontSize: 14)),
        ],
      ),
    );
  }
}
