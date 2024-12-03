# **IoT in Agriculture**

A comprehensive project leveraging IoT (Internet of Things) and machine learning to optimize agricultural processes. This repository includes sensor integration, data visualization, machine learning models for water classification, and a web interface to manage and analyze agricultural data.

<img src="https://github.com/user-attachments/assets/a2c9b229-be64-4fa0-8714-30ec5908bea7" width="500"/>
<img src="https://github.com/user-attachments/assets/cb79cc6a-80d5-4446-a36d-c1d730799e2f" width="500"/>


---

## **Features**
- **Soil Moisture Monitoring:** Real-time data collection from a soil moisture sensor.
- **Environmental Monitoring:** Integration with a DHT11 sensor to track temperature and humidity.
- **Water Classification:** Machine learning model to determine water requirements based on environmental and soil data.
- **Manual and Automatic Modes:** 
  - **Manual Mode:** Input data directly and get immediate classification results.
  - **Automatic Mode:** Analyze daily average sensor data for classification.
- **Data Visualization:** Charts and tables to display historical and real-time data.
- **Web Interface:** Built with PHP and MySQL for intuitive data management and visualization.

---

## **Tech Stack**
- **Programming Languages:** Python, PHP, SQL
- **Backend:** Python, PHP
- **Frontend:** HTML, CSS, JavaScript
- **Database:** MySQL
- **Machine Learning:** decision tree model, Random Forest Model, gradient boosting model and neural network (scikit-learn)
- **IoT Integration:** Arduino-compatible sensors (Soil Moisture Sensor, DHT11)

---

## **Project Structure**
```plaintext
IoT-in-Agriculture/
├── model/
│   └── random_forest_model.joblib            # Pre-trained machine learning model
├── Application_Web_Planet_Watering/
│   ├── classify.php                          # Script for manual and automatic classification
│   └── index.php                             # Web interface homepage
│   └── style.css                             # Stylesheets for the web interface
|   └── ...            
├── CODE_Irrigation_Automatic/
│   └── CODE_Irrigation_Automatic.ino         # Code for Soil Moisture Sensor integration using arduino uno 
├── Code_ESP32_Blynk_Plant_Watering/
│   └── Code_ESP32_Blynk_Plant_Watering.ino   # code for integration blynk app using ESP32 and return data to the server
├── scripts/
│   └── classify.py                           # Script for sending data of the model to the web app
└── README.md                                 # Project documentation
```

## **Installation**

### **1. Clone the Repository**
```bash
git clone https://github.com/a-alhaouil/IoT-in-Agreculture.git
cd IoT-in-Agreculture
```
## **Installation**

### **2. Set Up Python Environment**
```bash
python -m venv venv
source venv/bin/activate  # On Windows: venv\Scripts\activate
pip install -r requirements.txt
```

### **3. Configure PHP and MySQL**
- Ensure you have a PHP server (XAMPP) running.
- Create a MySQL database and import the provided SQL schema.
- Update php files with your database credentials.

### **4. Upload Machine Learning Model**
Ensure the pre-trained Random Forest model is located at:
```plaintext
model/random_forest_model.joblib
```

## **Usage**

### **1. Sensor Data Collection**
- Set up the soil moisture sensor and DHT11 sensor on your Arduino board.
- Run the respective scripts in the `Code_ESP32_Blynk_Plant_Watering\` directory to collect data.

### **2. Data Upload**
- Use the php scripts to send sensor data to the web server.

### **3. Web Interface**
- Navigate to `index.php` in your browser to access the web interface.
- Use the **Manual Mode** to input data or the **Automatic Mode** to analyze daily averages.

---

## **Blynk Integration**
This project also integrates with the **Blynk IoT Platform** to remotely monitor and control the system. Here's how to connect it:

1. Set up a Blynk account at [https://blynk.io](https://blynk.io).
2. Create a new project in the Blynk app and get your **Auth Token**.
3. Set up the Arduino with the Blynk library and upload the code to your board to send sensor data to the Blynk server.
4. You can monitor soil moisture and other data on the Blynk mobile app.

**Blynk Features**:
- Real-time monitoring of soil moisture and temperature.
- Control pumps or other connected devices directly from the app.

---
## **System Architecture**

The architecture of the system consists of several key components that work together to monitor and manage soil moisture and other environmental parameters. Here's a diagram representing the overall structure:

### **System Components:**
- **Arduino Board**: Collects data from sensors (soil moisture, DHT11).
- **Sensors**: Soil moisture sensor and DHT11 sensor.
- **Blynk IoT Platform**: Provides real-time remote monitoring and control.
- **Web Interface**: Used to display data and control modes (manual/automatic).
- **PHP and MySQL**: Used for storing and displaying sensor data through the web interface.

### **System Architecture Diagram:**

Below is a diagram showing the architecture of the system:

![Untitled Sketch_bb12](https://github.com/user-attachments/assets/70b951f9-a7d9-4cd6-b102-ea874e7f07d1)

---
### **MySQL Database:**
This project uses a MySQL database to store and manage sensor data. The database schema includes tables for storing sensor readings and other relevant information. The schema is provided in the `database/` folder.

- **Extracted Database**: You can import the provided SQL file to set up your database.
  - Database schema: `database/iotdb.sql`
  - **Steps**:
    1. Create a new MySQL database.
    2. Import the SQL schema file provided in the `database/` folder.

![image](https://github.com/user-attachments/assets/999d9649-6736-4817-8a30-689b950db775)

![image](https://github.com/user-attachments/assets/e107e712-cf0d-4aab-b13c-eed051a9476f)

![image](https://github.com/user-attachments/assets/b0a6a378-12b7-4eca-b7fa-778a9ae14c38)


---
## **Images of the Blynk App and Web Interface**

### **Blynk App Interface**
Below is a screenshot of the Blynk app displaying the real-time sensor data and control buttons:
<img src="https://github.com/user-attachments/assets/ad539325-5b97-4386-99d8-b2e2ad28379a" width="500"/>


### **Web Interface**
Here is a screenshot of the web interface where you can input data manually or analyze automatic mode results:

![Capture d'écran 2024-09-29 031858](https://github.com/user-attachments/assets/04050f09-267c-4f5d-bed8-40c1c8c51ce4)
![Capture d'écran 2024-09-29 031954](https://github.com/user-attachments/assets/42a04493-54e9-4828-b201-163f27c61a14)
![Capture d'écran 2024-09-29 031707](https://github.com/user-attachments/assets/d92d1bb1-b374-4e3c-8999-9f135b1d1c46)


---
## **Contributing**
Contributions are welcome! Please fork the repository, make your changes, and submit a pull request.
you can change HTTP Protocol with MQTT Protocol

---

## **License**
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## **Contact**
For questions or feedback, please contact:

- **Abdessamad Alhaouil**
- **Email:** abd.essamad.alhaouil@gmail.com
- **GitHub:** [a-alhaouil](https://github.com/a-alhaouil)
