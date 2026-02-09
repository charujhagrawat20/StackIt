import 'dart:math';
import 'package:flutter/material.dart';

void main() {
  runApp(const EmojiApp());
}

class EmojiApp extends StatelessWidget {
  const EmojiApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Emoji App',
      home: const EmojiHome(),
    );
  }
}

class EmojiHome extends StatefulWidget {
  const EmojiHome({super.key});

  @override
  State<EmojiHome> createState() => _EmojiHomeState();
}

class _EmojiHomeState extends State<EmojiHome> {
  final List<String> emojis = [
    '😀','😃','😄','😁','😆'
  ];

  String currentEmoji='😀';
  final Random random = Random();

  void changeEmoji(){
    setState(() {
      currentEmoji = emojis[random.nextInt(emojis.length)];
    });
  }

  @override
  Widget build(BuildContext context){
    return Scaffold(
      appBar: AppBar(
        title: const Text('Hello Emoji App'),
        centerTitle: true,
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              currentEmoji,
              style: const TextStyle(fontSize: 120),
            ),
            const SizedBox(height: 30),
            ElevatedButton(
              onPressed: changeEmoji, 
              child: const Text(
                'Tap Me',
                style:TextStyle(fontSize: 18),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
