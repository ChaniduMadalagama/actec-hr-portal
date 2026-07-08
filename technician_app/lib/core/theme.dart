import 'package:flutter/material.dart';

class AppTheme {
  static const Color primary = Color(0xFF000000); // Black
  static const Color primaryContainer = Color(0xFF131B2E); // Deep Blue
  static const Color secondary = Color(0xFF0058BE); // LogiFlow Blue
  static const Color secondaryAccent = Color(0xFF00DBE7); // Cyan
  static const Color background = Color(0xFF1A1B3A); // Main Background
  static const Color surface = Color(0xFF14152D); // Surface
  static const Color error = Color(0xFFBA1A1A);
  static const Color textOnSurface = Color(0xFFE0E3E5);
  static const Color textOutline = Color(0xFF76777D);

  static final ThemeData darkTheme = ThemeData(
    brightness: Brightness.dark,
    primaryColor: secondary,
    scaffoldBackgroundColor: background,
    fontFamily: 'Inter',
    colorScheme: const ColorScheme.dark(
      primary: secondary,
      secondary: secondaryAccent,
      surface: surface,
      error: error,
      onPrimary: Colors.white,
      onSecondary: Colors.black,
      onSurface: textOnSurface,
    ),
    inputDecorationTheme: InputDecorationTheme(
      filled: true,
      fillColor: primaryContainer,
      contentPadding: const EdgeInsets.symmetric(horizontal: 20, vertical: 18),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: Colors.white10),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: Colors.white10),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: secondary, width: 2),
      ),
      errorBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: error),
      ),
      hintStyle: const TextStyle(color: textOutline, fontSize: 14),
      labelStyle: const TextStyle(color: textOutline, fontSize: 14, letterSpacing: 1.1, fontWeight: FontWeight.bold),
    ),
    elevatedButtonTheme: ElevatedButtonThemeData(
      style: ElevatedButton.styleFrom(
        backgroundColor: secondary,
        foregroundColor: Colors.white,
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        elevation: 4,
        shadowColor: secondary.withValues(alpha: 0.5),
        textStyle: const TextStyle(
          fontSize: 16,
          fontWeight: FontWeight.bold,
        ),
      ),
    ),
  );
}
