class Job {
  final int id;
  final String clientName;
  final String clientPhone;
  final String serviceAddress;
  final double latitude;
  final double longitude;
  final String issueDescription;
  final String status;
  final int assignedTo;
  final DateTime? scheduledAt;

  Job({
    required this.id,
    required this.clientName,
    required this.clientPhone,
    required this.serviceAddress,
    required this.latitude,
    required this.longitude,
    required this.issueDescription,
    required this.status,
    required this.assignedTo,
    this.scheduledAt,
  });

  factory Job.fromJson(Map<String, dynamic> json) {
    return Job(
      id: json['id'] as int,
      clientName: json['clientName'] as String? ?? '',
      clientPhone: json['clientPhone'] as String? ?? '',
      serviceAddress: json['serviceAddress'] as String? ?? '',
      latitude: double.tryParse(json['latitude']?.toString() ?? '0') ?? 0.0,
      longitude: double.tryParse(json['longitude']?.toString() ?? '0') ?? 0.0,
      issueDescription: json['issueDescription'] as String? ?? '',
      status: json['status'] as String? ?? 'pending',
      assignedTo: json['assignedTo'] as int? ?? 0,
      scheduledAt: json['scheduledAt'] != null
          ? DateTime.tryParse(json['scheduledAt'] as String)
          : null,
    );
  }
}
