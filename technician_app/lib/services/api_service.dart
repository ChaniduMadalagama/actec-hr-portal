// ignore_for_file: avoid_print
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/user.dart';
import '../models/job.dart';

class ApiService {
  static String? _baseUrlOverride;
  static const String defaultBaseUrl = 'http://192.168.1.4:8000/api/v1';

  static Future<String> get baseUrl async {
    if (_baseUrlOverride != null) return _baseUrlOverride!;
    final prefs = await SharedPreferences.getInstance();
    _baseUrlOverride = prefs.getString('api_base_url') ?? defaultBaseUrl;
    return _baseUrlOverride!;
  }

  static Future<void> setBaseUrl(String newUrl) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('api_base_url', newUrl);
    _baseUrlOverride = newUrl;
  }

  // Helper request sender with logging built-in
  static Future<http.Response> _sendRequest(
    String method,
    String path, {
    Map<String, String>? headers,
    dynamic body,
  }) async {
    final base = await baseUrl;
    final url = Uri.parse('$base$path');
    final Map<String, String> requestHeaders = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      ...?headers,
    };

    // Print Request Details to Console
    print('📡 --- HTTP REQUEST ---');
    print('METHOD : $method');
    print('URL    : $url');
    print('HEADERS: $requestHeaders');
    if (body != null) {
      print('BODY   : $body');
    }
    print('----------------------');

    http.Response response;
    try {
      if (method == 'POST') {
        response = await http.post(url, headers: requestHeaders, body: body);
      } else {
        response = await http.get(url, headers: requestHeaders);
      }
    } catch (e) {
      print('❌ HTTP CONNECTION ERROR: $e');
      rethrow;
    }

    // Print Response Details to Console
    print('📥 --- HTTP RESPONSE ---');
    print('STATUS : ${response.statusCode}');
    print('BODY   : ${response.body}');
    print('-----------------------');

    return response;
  }

  static Future<Map<String, dynamic>> login(
    String username,
    String password,
  ) async {
    try {
      final response = await _sendRequest(
        'POST',
        '/auth/login',
        body: jsonEncode({'username': username, 'password': password}),
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 200 && data['token'] != null) {
        // Save token & user profile
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('api_token', data['token']);
        await prefs.setString('user_profile', jsonEncode(data['user']));

        // Parse and return user
        return {'success': true, 'user': User.fromJson(data['user'])};
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Invalid credentials',
        };
      }
    } catch (e) {
      return {
        'success': false,
        'message': 'Failed to connect to the server: $e',
      };
    }
  }

  static Future<User?> getCachedUser() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final userStr = prefs.getString('user_profile');
      if (userStr != null) {
        return User.fromJson(jsonDecode(userStr));
      }
    } catch (e) {
      print('Error decoding cached user: $e');
    }
    return null;
  }

  static Future<List<Job>> getAssignedJobs() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('api_token');
      if (token == null) {
        print('⚠️ API ERROR: Missing stored api_token');
        return [];
      }

      final response = await _sendRequest(
        'GET',
        '/tech/jobs/assigned',
        headers: {'Authorization': 'Bearer $token'},
      );

      if (response.statusCode == 200) {
        final decoded = jsonDecode(response.body);
        if (decoded is List) {
          return decoded
              .map((json) => Job.fromJson(json as Map<String, dynamic>))
              .toList();
        } else if (decoded is Map && decoded['data'] != null) {
          final List<dynamic> jobsJson = decoded['data'];
          return jobsJson
              .map((json) => Job.fromJson(json as Map<String, dynamic>))
              .toList();
        }
      }
      return [];
    } catch (e) {
      print('❌ ERROR GETTING JOBS: $e');
      return [];
    }
  }

  static Future<Map<String, dynamic>> startRoute(int jobId) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('api_token');
      if (token == null) return {'success': false, 'message': 'Not logged in'};

      final response = await _sendRequest(
        'POST',
        '/tech/jobs/$jobId/start-route',
        headers: {'Authorization': 'Bearer $token'},
      );

      final data = jsonDecode(response.body);
      if (response.statusCode == 200) {
        return {'success': true};
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Failed to start route',
        };
      }
    } catch (e) {
      return {'success': false, 'message': 'Connection error: $e'};
    }
  }

  static Future<Map<String, dynamic>> checkIn(
    int jobId,
    double lat,
    double lng,
  ) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('api_token');
      if (token == null) return {'success': false, 'message': 'Not logged in'};

      final response = await _sendRequest(
        'POST',
        '/tech/jobs/$jobId/check-in',
        headers: {'Authorization': 'Bearer $token'},
        body: jsonEncode({
          'hardware_timestamp': DateTime.now().toIso8601String(),
          'latitude': lat,
          'longitude': lng,
        }),
      );

      final data = jsonDecode(response.body);
      if (response.statusCode == 200) {
        return {'success': true};
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Failed to check in',
        };
      }
    } catch (e) {
      return {'success': false, 'message': 'Connection error: $e'};
    }
  }

  static Future<Map<String, dynamic>> checkOut(
    int jobId,
    double lat,
    double lng,
  ) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('api_token');
      if (token == null) return {'success': false, 'message': 'Not logged in'};

      final response = await _sendRequest(
        'POST',
        '/tech/jobs/$jobId/check-out',
        headers: {'Authorization': 'Bearer $token'},
        body: jsonEncode({
          'hardware_timestamp': DateTime.now().toIso8601String(),
          'latitude': lat,
          'longitude': lng,
        }),
      );

      final data = jsonDecode(response.body);
      if (response.statusCode == 200) {
        return {'success': true};
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Failed to check out',
        };
      }
    } catch (e) {
      return {'success': false, 'message': 'Connection error: $e'};
    }
  }

  static Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('api_token');
    await prefs.remove('user_profile');
  }

  static Future<bool> isLoggedIn() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('api_token') != null;
  }
}
