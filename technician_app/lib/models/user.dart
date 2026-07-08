class User {
  final int id;
  final String name;
  final String email;
  final String username;
  final String role;
  final String currentStatus;

  User({
    required this.id,
    required this.name,
    required this.email,
    required this.username,
    required this.role,
    required this.currentStatus,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'] as int,
      name: json['name'] as String,
      email: json['email'] as String,
      username: json['username'] as String,
      role: json['role'] as String,
      currentStatus: json['currentStatus'] as String,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'username': username,
      'role': role,
      'currentStatus': currentStatus,
    };
  }
}
