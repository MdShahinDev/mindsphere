# /python/score_user.py
import mysql.connector
import joblib
import sys
import json

# Get user_id from PHP (command line)
user_id = int(sys.argv[1])

# Load model
model = joblib.load("python/efficiency_model.pkl")

# Habits in order used during training
habit_names = [
    'drink_water', 'exercise', 'sound_sleep', 'blood_pressure', 'meal',
    'meditation', 'journaling', 'gratitude', 'mood_checkin', 'clam_breathing',
    'work_hours', 'social_media_usage', 'task_done', 'pomodoro_session', 'break_time',
    'reading', 'course', 'smart_recall', 'new_skill', 'learn_and_log'
]

# Connect to DB
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",      # ← Replace with your DB password
    database="mindspheredb"       # ← Replace with your DB name
)

cursor = conn.cursor(dictionary=True)
cursor.execute("""
SELECT habit_name, habit_value_score
FROM habit_logs
WHERE user_id = %s AND date = CURDATE()
""", (user_id,))

rows = cursor.fetchall()
habit_map = {row['habit_name']: row['habit_value_score'] for row in rows}

# Build input vector
input_vector = [habit_map.get(h, 0) for h in habit_names]

# Predict
score = model.predict([input_vector])[0]
print(json.dumps({"score": round(score)}))
