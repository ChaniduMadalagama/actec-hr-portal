import 'package:flutter/material.dart';
import '../core/theme.dart';
import 'dashboard_tab.dart';
import 'jobs_tab.dart';
import 'more_tab.dart';

class MainNavigationScreen extends StatefulWidget {
  const MainNavigationScreen({super.key});

  @override
  State<MainNavigationScreen> createState() => _MainNavigationScreenState();
}

class _MainNavigationScreenState extends State<MainNavigationScreen> {
  int _currentIndex = 0;

  late final List<Widget> _tabs;

  @override
  void initState() {
    super.initState();
    _tabs = [
      DashboardTab(onNavigateToJobs: () {
        setState(() {
          _currentIndex = 1;
        });
      }),
      const JobsTab(),
      const MoreTab(),
    ];
  }

  String _getAppBarTitle() {
    switch (_currentIndex) {
      case 0:
        return 'LogiFlow Dispatch';
      case 1:
        return 'Dispatch Orders';
      case 2:
        return 'System & Settings';
      default:
        return 'LogiFlow';
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.background,
      appBar: AppBar(
        title: Text(
          _getAppBarTitle(),
          style: const TextStyle(letterSpacing: 1.2, fontWeight: FontWeight.bold),
        ),
        backgroundColor: AppTheme.surface,
        elevation: 0,
        centerTitle: false,
      ),
      body: IndexedStack(
        index: _currentIndex,
        children: _tabs,
      ),
      bottomNavigationBar: Container(
        decoration: const BoxDecoration(
          border: Border(
            top: BorderSide(color: Colors.white10, width: 1),
          ),
        ),
        child: BottomNavigationBar(
          currentIndex: _currentIndex,
          onTap: (index) {
            setState(() {
              _currentIndex = index;
            });
          },
          backgroundColor: AppTheme.surface,
          selectedItemColor: AppTheme.secondaryAccent,
          unselectedItemColor: AppTheme.textOutline,
          selectedLabelStyle: const TextStyle(fontWeight: FontWeight.bold, fontSize: 12),
          unselectedLabelStyle: const TextStyle(fontSize: 12),
          type: BottomNavigationBarType.fixed,
          items: const [
            BottomNavigationBarItem(
              icon: Icon(Icons.dashboard_outlined),
              activeIcon: Icon(Icons.dashboard),
              label: 'Dashboard',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.assignment_outlined),
              activeIcon: Icon(Icons.assignment),
              label: 'Jobs',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.more_horiz_outlined),
              activeIcon: Icon(Icons.more_horiz),
              label: 'More',
            ),
          ],
        ),
      ),
    );
  }
}
