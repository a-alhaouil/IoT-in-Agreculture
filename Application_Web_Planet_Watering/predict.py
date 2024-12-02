
import sys
import numpy as np
import warnings
import joblib

warnings.filterwarnings('ignore')

# Update model path
MODEL_PATH = r"C:\Users\abdes\Desktop\IoT-in-Agreculture\model\withoutpumpdatafeature\neural_network_modelv2.joblib"

# Load the model
try:
    model = joblib.load(MODEL_PATH)
except Exception as e:
    print(f"Error loading model: {e}")
    sys.exit(1)

# Status mapping
STATUS_MAPPING = {0: 'water wasted', 1: 'increase water', 2: 'decrease water'}

def predict_water_status(model, soil_moisture, temperature, air_humidity):
    """
    Predict the water status based on soil moisture, temperature, and air humidity.

    Parameters:
    model (sklearn.base.BaseEstimator): The trained model.
    soil_moisture (float): The soil moisture value.
    temperature (float): The temperature value.
    air_humidity (float): The air humidity value.

    Returns:
    str: The predicted water status.
    """
    input_data = np.array([[soil_moisture, temperature, air_humidity]])
    prediction = model.predict(input_data)
    return STATUS_MAPPING[prediction[0]]

def main():
    # Get inputs from command line arguments
    if len(sys.argv) == 4:
        try:
            soil_moisture = float(sys.argv[1])
            temperature = float(sys.argv[2])
            air_humidity = float(sys.argv[3])

            # Predict using the model
            water_status = predict_water_status(model, soil_moisture, temperature, air_humidity)
            print(water_status)
        except ValueError as e:
            print(f"Invalid input values: {e}")
    else:
        print("Invalid arguments. Please provide soil moisture, temperature, and air humidity.")

if __name__ == "__main__":
    main()



# import sys
# import joblib
# import numpy as np
# import warnings
# import pickle
# warnings.filterwarnings('ignore')

# # # Update model path
# # MODEL_PATH = r"C:\Users\abdes\Desktop\IoT-in-Agreculture-master\IoT-in-Agreculture-master\model\withoutpumpdatafeature\random_forest_model.joblib"

# # # Load the model
# # try:
# #     model = joblib.load(MODEL_PATH)
# # except Exception as e:
# #     print(f"Error loading model: {e}")
# #     sys.exit(1)


# # Update model path
# MODEL_PATH = r"C:\Users\abdes\Desktop\IoT-in-Agreculture-master\IoT-in-Agreculture-master\model\random_forest_model.pkl"

# # Load the model
# try:
#     with open(MODEL_PATH, 'rb') as file:
#         model = pickle.load(file)
# except Exception as e:
#     print(f"Error loading model: {e}")
#     sys.exit(1)

# # Status mapping
# STATUS_MAPPING = {0: 'water wasted', 1: 'increase water', 2: 'decrease water'}

# def predict_water_status(model, soil_moisture, temperature, air_humidity):
#     """
#     Predict the water status based on soil moisture, temperature, and air humidity.

#     Parameters:
#     model (sklearn.base.BaseEstimator): The trained model.
#     soil_moisture (float): The soil moisture value.
#     temperature (float): The temperature value.
#     air_humidity (float): The air humidity value.

#     Returns:
#     str: The predicted water status.
#     """
#     input_data = np.array([[soil_moisture, temperature, air_humidity]])
#     prediction = model.predict(input_data)
#     return STATUS_MAPPING[prediction[0]]

# def main():
#     # Get inputs from command line arguments
#     if len(sys.argv) == 4:
#         try:
#             soil_moisture = float(sys.argv[1])
#             temperature = float(sys.argv[2])
#             air_humidity = float(sys.argv[3])

#             # Predict using the model
#             water_status = predict_water_status(model, soil_moisture, temperature, air_humidity)
#             print(water_status)
#         except ValueError as e:
#             print(f"Invalid input values: {e}")
#     else:
#         print("Invalid arguments. Please provide soil moisture, temperature, and air humidity.")

# if __name__ == "__main__":
#     main()




# # Assume random_forest_model is your trained model
# random_forest_model = RandomForestClassifier()
# model_path = r"C:\Users\abdes\Desktop\IoT-in-Agreculture-master\IoT-in-Agreculture-master\model\random_forest_model.pkl"

# # Later on, load the model
# with open(model_path, 'rb') as file:
#     loaded_model = pickle.load(file)  

# model_path = r"C:\Users\abdes\Desktop\IoT-in-Agreculture-master\IoT-in-Agreculture-master\model\random_forest_model.skops"

# import skops.io as sio
# obj = sio.dump(random_forest_model, "random_forest_model.skops")

# unknown_types = sio.get_untrusted_types(file="random_forest_model.skops")
# # investigate the contents of unknown_types, and only load if you trust
# # everything you see.
# random_forest_model = sio.load(model_path, trusted=unknown_types)
