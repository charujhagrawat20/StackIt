Emoji App
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







Simple Login
import 'package:flutter/material.dart';

void main() {
  runApp(const LoginApp());
}

class LoginApp extends StatelessWidget {
  const LoginApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Login Screen',
      home: const LoginScreen(),
    );
  }
}

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final TextEditingController usernameController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  void login(){
    if(usernameController.text.isNotEmpty && passwordController.text.isNotEmpty){
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Please enter all fields'),
          backgroundColor: Colors.red,
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Login Screen'),
        centerTitle: true,
      ),
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TextField(
              controller: usernameController,
              decoration: const InputDecoration(
                labelText: 'Username',
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height:20),
            TextField(
              controller: passwordController,
              obscureText: true,
              decoration: const InputDecoration(
                labelText: 'Password',
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 30),
            ElevatedButton(
              onPressed: login, 
              child: const Text('Login'),
            ),
          ],
        ),
      ),
    );
  }
}



Email Validation
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';

void main() {
  runApp(const SmartLoginApp());
}

class SmartLoginApp extends StatelessWidget {
  const SmartLoginApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: LoginForm(),
    );
  }
}

class LoginForm extends StatefulWidget {
  const LoginForm({super.key});

  @override
  State<LoginForm> createState() => _LoginFormState();
}

class _LoginFormState extends State<LoginForm> {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  bool isButtonEnabled = false;

  void validateForm(){
    setState(() {
      isButtonEnabled = emailController.text.contains('@') && passwordController.text.length>=6;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Smart Login Form"),
        centerTitle: true,
      ),
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TextField(
              controller: emailController,
              onChanged: (_)=>validateForm(),
              decoration: const InputDecoration(
                labelText: 'Email',
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 30),
            ElevatedButton(
              onPressed: isButtonEnabled ? showToast : null, 
              child: const Text("Login"),
            ),
          ],
        ),
      ),
    );
  }
}




Theme Color Chnager
import 'package:flutter/material.dart';

void main() {
  runApp(const ThemeColorChangerApp());
}

class ThemeColorChangerApp extends StatelessWidget {
  const ThemeColorChangerApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: const ThemeChangerScreen(),
    );
  }
}

class ThemeChangerScreen extends StatefulWidget {
  const ThemeChangerScreen({super.key});
  
  @override
  State<ThemeChangerScreen> createState() => _ThemeChangerScreenState();
}

class _ThemeChangerScreenState extends State<ThemeChangerScreen> {
  Color backgroundColor = Colors.white;

  void changeColor(Color color){
    setState(() {
      backgroundColor = color;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Theme Color Changer"),
        centerTitle: true,
      ),
      body: Center(
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue,
              ),
              onPressed: ()=>changeColor(Colors.blue.shade100), 
              child: const Text("Blue"),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.orange,
              ),
              onPressed: ()=>changeColor(Colors.orange.shade100), 
              child: const Text("Orange"),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.green,
              ),
              onPressed: ()=>changeColor(Colors.green.shade100), 
              child: const Text("Green"),
            ),
          ],
        ),
      ),
    );
  }
}






Counter with Auto Increment
import 'dart:async';
import 'package:flutter/material.dart';

void main() {
  runApp(const CounterApp());
}

class CounterApp extends StatelessWidget {
  const CounterApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: CounterScreen(),
    );
  }
}

class CounterScreen extends StatefulWidget {
  const CounterScreen({super.key});
  
  @override
  State<CounterScreen> createState() => _CounterScreenState();
}

class _CounterScreenState extends State<CounterScreen> {
  int counter = 0;
  Timer ? timer;

  void startCounter(){
    timer ??= Timer.periodic(
      const Duration(seconds:1), 
      (Timer t){
        setState(() {
          counter++;
        });
      },
    );
  }

  void pauseCounter(){
    timer ?.cancel();
    timer = null;
  }

  void resetCounter(){
    pauseCounter();
    setState(() {
      counter = 0;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Auto Increment Counter"),
        centerTitle: true,
      ),
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(
            counter.toString(),
            style: const TextStyle(
              fontSize: 80,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 40),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              ElevatedButton(
                onPressed: startCounter,
                child: const Text("Start"),
              ),
              ElevatedButton(
                onPressed: pauseCounter, 
                child: const Text("Pause"),
              ),
              ElevatedButton(
                onPressed: resetCounter, 
                child: const Text("Reset"),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
