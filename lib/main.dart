import 'package:dyabd/classes/class.manager.dart';
import 'package:flutter/material.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatefulWidget {
  final dbService = DatabaseService();
  MyApp({super.key});

  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  late Future<List<Map<String, dynamic>>> clientsFuture;
  late Future<List<Map<String, dynamic>>> ordersFuture;

  @override
  void initState() {
    super.initState();
    // Inicializa clientsFuture y ordersFuture al cargar la pantalla.
    clientsFuture = widget.dbService.getClients();
    ordersFuture = widget.dbService.getOrders(); // Utiliza el método getOrders para obtener la lista de pedidos.
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: Scaffold(
        appBar: AppBar(
          title: Text(
            'Lista de Clientes y Pedidos',
            style: TextStyle(color: Colors.white),
          ),
          backgroundColor: Colors.black,
        ),
        body: SingleChildScrollView(
          child: Row(
            children: [
              Expanded(
                child: Column(
                  children: [
                    Text(
                      'Clientes',
                      style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                    ),
                    // Columna para mostrar la lista de clientes
                    FutureBuilder(
                      future: clientsFuture,
                      builder: (context, snapshot) {
                        if (snapshot.connectionState == ConnectionState.waiting) {
                          return Center(child: CircularProgressIndicator());
                        } else if (snapshot.hasError) {
                          return Center(child: Text('Error: ${snapshot.error}'));
                        } else {
                          List<Map<String, dynamic>> clients =
                              (snapshot.data as List<Map<String, dynamic>>?) ?? [];
                          return ListView.builder(
                            shrinkWrap: true,
                            itemCount: clients.length,
                            itemBuilder: (context, index) {
                              final client = clients[index];
                              return ListTile(
                                title: Text(client['nombre']),
                                subtitle: Text(client['direccion']),
                              );
                            },
                          );
                        }
                      },
                    ),
                  ],
                ),
              ),
              Expanded(
                child: Column(
                  children: [
                    Text(
                      'Pedidos',
                      style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                    ),
                    // Columna para mostrar la lista de pedidos
                    FutureBuilder(
                      future: ordersFuture,
                      builder: (context, snapshot) {
                        if (snapshot.connectionState == ConnectionState.waiting) {
                          return Center(child: CircularProgressIndicator());
                        } else if (snapshot.hasError) {
                          return Center(child: Text('Error: ${snapshot.error}'));
                        } else {
                          List<Map<String, dynamic>> orders =
                              (snapshot.data as List<Map<String, dynamic>>?) ?? [];
                          return ListView.builder(
                            shrinkWrap: true,
                            itemCount: orders.length,
                            itemBuilder: (context, index) {
                              final order = orders[index];
                              return ListTile(
                                title: Text(order['fechaPedido']),
                                subtitle: Text(order['total']),
                              );
                            },
                          );
                        }
                      },
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
