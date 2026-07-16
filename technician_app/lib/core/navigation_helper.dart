import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

class NavigationHelper {
  static Future<void> launchGoogleMaps(
    BuildContext context, {
    required double latitude,
    required double longitude,
  }) async {
    final List<Map<String, dynamic>> uris = [
      {
        'uri': Uri.parse('google.navigation:q=$latitude,$longitude'),
        'mode': LaunchMode.externalNonBrowserApplication,
      },
      {
        'uri': Uri.parse('https://www.google.com/maps/dir/?api=1&destination=$latitude,$longitude&travelmode=driving'),
        'mode': LaunchMode.externalApplication,
      },
      {
        'uri': Uri.parse('geo:$latitude,$longitude?q=$latitude,$longitude'),
        'mode': LaunchMode.externalApplication,
      },
      {
        'uri': Uri.parse('https://www.google.com/maps/search/?api=1&query=$latitude,$longitude'),
        'mode': LaunchMode.externalApplication,
      },
    ];

    bool launched = false;
    for (final item in uris) {
      final Uri uri = item['uri'] as Uri;
      final LaunchMode mode = item['mode'] as LaunchMode;
      try {
        if (await canLaunchUrl(uri)) {
          final success = await launchUrl(uri, mode: mode);
          if (success) {
            launched = true;
            break;
          }
        }
      } catch (e) {
        debugPrint('Failed to launch $uri: $e');
      }
    }

    // Try a direct launch of the HTTPS web navigation link as a final fallback
    // (Bypasses package visibility queries on Android 11+)
    if (!launched) {
      try {
        final fallbackUri = Uri.parse(
          'https://www.google.com/maps/dir/?api=1&destination=$latitude,$longitude&travelmode=driving',
        );
        launched = await launchUrl(fallbackUri, mode: LaunchMode.externalApplication);
      } catch (e) {
        debugPrint('Direct fallback launch failed: $e');
      }
    }

    if (launched) return;

    // Show prompt to download Google Maps if all launches fail
    if (context.mounted) {
      showDialog(
        context: context,
        builder: (context) => AlertDialog(
          title: const Row(
            children: [
              Icon(Icons.map_outlined, color: Colors.blue),
              SizedBox(width: 8),
              Text('Google Maps Required'),
            ],
          ),
          content: const Text(
            'Google Maps is required for route navigation. Please install the Google Maps app to proceed.',
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Cancel', style: TextStyle(color: Colors.white70)),
            ),
            TextButton(
              onPressed: () async {
                Navigator.pop(context);
                final playStoreUri = Uri.parse('market://details?id=com.google.android.apps.maps');
                final fallbackWebUri = Uri.parse('https://play.google.com/store/apps/details?id=com.google.android.apps.maps');
                
                if (await canLaunchUrl(playStoreUri)) {
                  await launchUrl(playStoreUri, mode: LaunchMode.externalApplication);
                } else {
                  await launchUrl(fallbackWebUri, mode: LaunchMode.externalApplication);
                }
              },
              child: const Text('Download App', style: TextStyle(color: Colors.blue)),
            ),
          ],
        ),
      );
    }
  }
}
