# /python/train_model.py
import pandas as pd
import mysql.connector
from sklearn.ensemble import RandomForestRegressor
import joblib

# Connect to your MySQL database
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",     # ← Replace with your DB password
    database="mindspheredb"      # ← Replace with your DB name
)

query = """ 
SELECT 
  user_id,
  date,
  MAX(CASE WHEN habit_name = 'drink_water' THEN habit_value_score ELSE NULL END) AS drink_water,
  MAX(CASE WHEN habit_name = 'exercise' THEN habit_value_score ELSE NULL END) AS exercise,
  MAX(CASE WHEN habit_name = 'sound_sleep' THEN habit_value_score ELSE NULL END) AS sound_sleep,
  MAX(CASE WHEN habit_name = 'blood_pressure' THEN habit_value_score ELSE NULL END) AS blood_pressure,
  MAX(CASE WHEN habit_name = 'meal' THEN habit_value_score ELSE NULL END) AS meal,
  MAX(CASE WHEN habit_name = 'meditation' THEN habit_value_score ELSE NULL END) AS meditation,
  MAX(CASE WHEN habit_name = 'journaling' THEN habit_value_score ELSE NULL END) AS journaling,
  MAX(CASE WHEN habit_name = 'gratitude' THEN habit_value_score ELSE NULL END) AS gratitude,
  MAX(CASE WHEN habit_name = 'mood_checkin' THEN habit_value_score ELSE NULL END) AS mood_checkin,
  MAX(CASE WHEN habit_name = 'clam_breathing' THEN habit_value_score ELSE NULL END) AS clam_breathing,
  MAX(CASE WHEN habit_name = 'work_hours' THEN habit_value_score ELSE NULL END) AS work_hours,
  MAX(CASE WHEN habit_name = 'social_media_usage' THEN habit_value_score ELSE NULL END) AS social_media_usage,
  MAX(CASE WHEN habit_name = 'task_done' THEN habit_value_score ELSE NULL END) AS task_done,
  MAX(CASE WHEN habit_name = 'pomodoro_session' THEN habit_value_score ELSE NULL END) AS pomodoro_session,
  MAX(CASE WHEN habit_name = 'break_time' THEN habit_value_score ELSE NULL END) AS break_time,
  MAX(CASE WHEN habit_name = 'reading' THEN habit_value_score ELSE NULL END) AS reading,
  MAX(CASE WHEN habit_name = 'course' THEN habit_value_score ELSE NULL END) AS course,
  MAX(CASE WHEN habit_name = 'smart_recall' THEN habit_value_score ELSE NULL END) AS smart_recall,
  MAX(CASE WHEN habit_name = 'new_skill' THEN habit_value_score ELSE NULL END) AS new_skill,
  MAX(CASE WHEN habit_name = 'learn_and_log' THEN habit_value_score ELSE NULL END) AS learn_and_log
FROM habit_logs
GROUP BY user_id, date
ORDER BY user_id, date;
"""

df = pd.read_sql(query, conn)
df.fillna(0, inplace=True)

# Rule-based efficiency score
df["efficiency_score"] = df.iloc[:, 2:].sum(axis=1) / 105 * 100

# Save CSV
df.to_csv("python/efficiency_data.csv", index=False)

# Train model
X = df.drop(columns=["efficiency_score", "user_id", "date"])
y = df["efficiency_score"]
model = RandomForestRegressor()
model.fit(X, y)

# Save trained model
joblib.dump(model, "python/efficiency_model.pkl")

print("✅ Model trained and saved to python/efficiency_model.pkl")
