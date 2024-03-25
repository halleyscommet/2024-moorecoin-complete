from flask import Flask, request, jsonify
import json
import hashlib
import os

app = Flask(__name__)

# JSON file to store user data
USER_DATA_FILE = "../Data/user_data.json"

# Create an initial empty JSON file if it doesn"t exist
try:
    with open(USER_DATA_FILE, "r") as file:
        pass
except FileNotFoundError:
    with open(USER_DATA_FILE, "w") as file:
        json.dump([], file)

# Helper function to read user data from the JSON file
def read_user_data():
    with open(USER_DATA_FILE, "r") as file:
        user_data = json.load(file)
    return user_data

# Helper function to write user data to the JSON file
def write_user_data(user_data):
    with open(USER_DATA_FILE, "w") as file:
        json.dump(user_data, file)

# Helper function to hash a password
def hash_password(password):
    return hashlib.sha256(password.encode()).hexdigest()

# API endpoint for user registration
@app.route("/teacher/signup", methods=["POST"])
def teachersignup():
    data = request.get_json()

    # Validate required fields
    if "email" not in data or "name" not in data or "password" not in data:
        return jsonify({"error": "Email, name and password are required"}), 400

    email = data["email"]
    name = data["name"]
    password = data["password"]

    user_data = read_user_data()
    if any(user["email"] == email for user in user_data):
        return jsonify({"error": "Email is already taken"}), 400

    # Hash the password before storing it
    hashed_password = hash_password(password)

    # Add the new user to the user data
    new_user = {"email": email, "name": name, "password": hashed_password}
    user_data.append(new_user)
    write_user_data(user_data)

    return jsonify({"message": "User registered successfully"}), 201

# API endpoint for user login
@app.route("/teacher/login", methods=["POST"])
def teacherlogin():
    data = request.get_json()

    # Validate required fields
    if "email" not in data or "password" not in data:
        return jsonify({"error": "Email and password are required"}), 400

    email = data["email"]
    password = data["password"]

    user_data = read_user_data()
    user = next((user for user in user_data if user["email"] == email), None)
    if user is None:
        return jsonify({"error": "Invalid email or password"}), 400

    # Check the password
    if user["password"] != hash_password(password):
        return jsonify({"error": "Invalid email or password"}), 400

    return jsonify({"message": "User logged in successfully"}), 200

@app.route("/teacher/create/class", methods=["POST"])
def createclass():
    data = request.get_json()

    # Validate required fields
    required_fields = ["email", "password", "class_name", "class_code"]
    if not all(field in data for field in required_fields):
        return jsonify({"error": "Email, password, class name and class code are required"}), 400

    email = data["email"]
    password = data["password"]
    class_name = data["class_name"]
    class_code = data["class_code"]

    user_data = read_user_data()
    user = next((user for user in user_data if user["email"] == email), None)
    if user is None or user["password"] != hash_password(password):
        return jsonify({"error": "Invalid email or password"}), 400

    # Create a new directory path
    class_dir = os.path.join("../Data/Classes", email, class_name)
    if os.path.exists(class_dir):
        return jsonify({"error": "Class name already exists"}), 400

    # Create the new directory
    os.makedirs(class_dir)

    # Create a new JSON file with the class information
    class_info_file = os.path.join(class_dir, "info.json")
    with open(class_info_file, "w") as file:
        json.dump({"class_name": class_name, "class_code": class_code, "money_supply": 50}, file)

    return jsonify({"message": "Class created successfully"}), 201

@app.route("/teacher/get/name", methods=["POST"])
def getname():
    data = request.get_json()

    # Validate required fields
    if "email" not in data or "password" not in data:
        return jsonify({"error": "Email and password are required"}), 400

    email = data["email"]
    password = data["password"]

    user_data = read_user_data()
    user = next((user for user in user_data if user["email"] == email), None)
    if user is None or user["password"] != hash_password(password):
        return jsonify({"error": "Invalid email or password"}), 400

    return jsonify({"name": user["name"]}), 200

@app.route("/teacher/get/classes", methods=["POST"])
def getclasses():
    data = request.get_json()

    # Validate required fields
    if "email" not in data or "password" not in data:
        return jsonify({"error": "Email and password are required"}), 400

    email = data["email"]
    password = data["password"]

    user_data = read_user_data()
    user = next((user for user in user_data if user["email"] == email), None)
    if user is None or user["password"] != hash_password(password):
        return jsonify({"error": "Invalid email or password"}), 400

    # Get the list of classes
    classes_dir = os.path.join("../Data/Classes", email)
    classes = []
    if os.path.exists(classes_dir):
        classes = [d for d in os.listdir(classes_dir) if os.path.isdir(os.path.join(classes_dir, d))]

    return jsonify({"classes": classes}), 200

@app.route("/teacher/get/class/code", methods=["POST"])
def getclasscode():
    data = request.get_json()

    # Validate required fields
    required_fields = ["email", "password", "class_name"]
    if not all(field in data for field in required_fields):
        return jsonify({"error": "Email, password and class name are required"}), 400

    email = data["email"]
    password = data["password"]
    class_name = data["class_name"]

    user_data = read_user_data()
    user = next((user for user in user_data if user["email"] == email), None)
    if user is None or user["password"] != hash_password(password):
        return jsonify({"error": "Invalid email or password"}), 400

    # Get the class code
    class_dir = os.path.join("../Data/Classes", email, class_name)
    if not os.path.exists(class_dir):
        return jsonify({"error": "Class does not exist"}), 400

    class_info_file = os.path.join(class_dir, "info.json")
    with open(class_info_file, "r") as file:
        class_info = json.load(file)

    return jsonify({"class_code": class_info["class_code"]}), 200

@app.route("/class/add/student", methods=["POST"])
def addstudent():
    data = request.get_json()

    # Validate required fields
    required_fields = ["email", "password", "class_code", "student_email"]
    if not all(field in data for field in required_fields):
        return jsonify({"error": "Email, password, class name and student email are required"}), 400

    email = data["email"]
    password = data["password"]
    class_code = data["class_code"]
    student_email = data["student_email"]

    user_data = read_user_data()
    user = next((user for user in user_data if user["email"] == email), None)
    if user is None or user["password"] != hash_password(password):
        return jsonify({"error": "Invalid email or password"}), 400

    # Get the class code
    class_dir = os.path.join("../Data/Classes", email, class_code)
    if not os.path.exists(class_dir):
        return jsonify({"error": "Class does not exist"}), 400

    class_info_file = os.path.join(class_dir, "info.json")
    with open(class_info_file, "r") as file:
        class_info = json.load(file)

    # Add the student to the class
    students_file = os.path.join(class_dir, "students.json")
    if os.path.exists(students_file):
        with open(students_file, "r") as file:
            students = json.load(file)
    else:
        students = []

    if student_email not in students:
        students.append(student_email)
        with open(students_file, "w") as file:
            json.dump(students, file)

    return jsonify({"message": "Student added to class successfully"}), 200

if __name__ == "__main__":
    app.run(debug=True)