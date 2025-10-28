#!/bin/bash

# Script to start both Laravel server and Stripe CLI for webhook testing
# This ensures webhooks are properly received and processed

echo "🚀 Starting Laravel Job Board Webhook System..."

# Kill any existing processes on port 8000
echo "🔧 Cleaning up existing processes on port 8000..."
lsof -ti:8000 | xargs kill -9 2>/dev/null || true

# Start Laravel development server in background
echo "📦 Starting Laravel development server on port 8000..."
cd /c/laragon/www/job-board-app
php artisan serve --host=127.0.0.1 --port=8000 &
LARAVEL_PID=$!

# Wait a moment for Laravel to start
sleep 3

# Check if Laravel server is running
if curl -s http://127.0.0.1:8000 > /dev/null; then
    echo "✅ Laravel server is running on port 8000"
else
    echo "❌ Laravel server failed to start"
    exit 1
fi

# Start Stripe CLI webhook forwarding
echo "💳 Starting Stripe CLI webhook forwarding..."
./stripe.exe listen --forward-to http://127.0.0.1:8000/stripe/webhook &
STRIPE_PID=$!

echo ""
echo "🎉 System is ready!"
echo "📝 Laravel Server PID: $LARAVEL_PID"
echo "📝 Stripe CLI PID: $STRIPE_PID" 
echo ""
echo "🔗 Application: http://127.0.0.1:8000"
echo "🔗 Webhook endpoint: http://127.0.0.1:8000/stripe/webhook"
echo ""
echo "Press Ctrl+C to stop both services..."

# Function to cleanup on script exit
cleanup() {
    echo ""
    echo "🛑 Stopping services..."
    kill $LARAVEL_PID 2>/dev/null || true
    kill $STRIPE_PID 2>/dev/null || true
    echo "✅ Services stopped"
    exit 0
}

# Set trap to cleanup on script exit
trap cleanup SIGINT SIGTERM

# Keep script running
wait