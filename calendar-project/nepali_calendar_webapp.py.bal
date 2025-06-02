from flask import Flask, render_template, request
import datetime

app = Flask(__name__)

# Function to generate a Nepali calendar
def generate_nepali_calendar(year, month):
    days_in_month = [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 30]  # Example days for Nepali calendar
    nepali_months = [
        "Baishakh", "Jestha", "Ashadh", "Shrawan", "Bhadra",
        "Ashwin", "Kartik", "Mangsir", "Poush", "Magh", "Falgun", "Chaitra"
    ]

    if month < 1 or month > 12:
        return None, None

    nepali_days = days_in_month[month - 1]
    nepali_month_name = nepali_months[month - 1]

    # Create a list of days for the month
    days = list(range(1, nepali_days + 1))
    return nepali_month_name, days

@app.route('/')
def home():
    # Get the current year and month
    now = datetime.datetime.now()
    year = now.year
    month = now.month

    # Generate the calendar
    nepali_month_name, days = generate_nepali_calendar(year, month)
    return render_template("calendar.html", year=year, month=month, nepali_month=nepali_month_name, days=days)

@app.route('/custom', methods=['GET', 'POST'])
def custom_calendar():
    if request.method == 'POST':
        year = int(request.form.get('year', datetime.datetime.now().year))
        month = int(request.form.get('month', datetime.datetime.now().month))
    else:
        year = datetime.datetime.now().year
        month = datetime.datetime.now().month

    nepali_month_name, days = generate_nepali_calendar(year, month)
    return render_template("calendar.html", year=year, month=month, nepali_month=nepali_month_name, days=days)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)

