import 'classes/class.manager.dart';

void main() async {
  final dbService = DatabaseService();

  try {
    final results = await dbService.getProducts();

    for (var result in results) {
      print(result);
    }
  } catch (e) {
    print('Error al obtener resultados: $e');
  }
}
