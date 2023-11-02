import 'package:http/http.dart' as http;
import 'dart:convert';

class DatabaseService {
  final String baseUrl =
      'http://190.114.204.8/phpuser/db_grupo1/query.php'; // URL del servidor PHP

  Future<List<Map<String, dynamic>>> getProducts() async {
    try {
      final response = await http.post(
        Uri.parse(baseUrl),
        headers: {'Content-Type': 'application/json'},
        body: json.encode({'query': 'SELECT * FROM `pedidos`'}),
      );

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        return List<Map<String, dynamic>>.from(jsonData);
      } else {
        throw Exception('Error en la solicitud al servidor.');
      }
    } catch (e) {
      throw Exception('Error en la consulta: $e');
    }
  }

  Future<List<Map<String, dynamic>>> queryExample(String query) async {
    try {
      final response = await http.post(
        Uri.parse(baseUrl),
        headers: {'Content-Type': 'application/json'},
        body: json.encode({'query': query}),
      );

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        return List<Map<String, dynamic>>.from(jsonData);
      } else {
        throw Exception('Error en la solicitud al servidor.');
      }
    } catch (e) {
      throw Exception('Error en la consulta: $e');
    }
  }
}
