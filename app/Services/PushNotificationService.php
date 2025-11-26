<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    /**
     * Send notification to a student
     *
     * @param int $studentId
     * @param string $title
     * @param string $message
     * @param array $data
     * @return bool
     */
    public function sendNotification($studentId, $title, $message, $data = [])
    {
        $student = Student::find($studentId);

        if (!$student) {
            Log::warning("Student with ID {$studentId} not found for notification");
            return false;
        }

        // Simulasi pengiriman notifikasi FCM/Push
        // Dalam implementasi nyata, gunakan Firebase Cloud Messaging atau service push notification lainnya

        $notificationData = [
            'student_id' => $studentId,
            'student_name' => $student->name,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'timestamp' => now()->toISOString(),
        ];

        // Log simulasi pengiriman notifikasi
        Log::info('Push Notification Sent (Simulated)', $notificationData);

        // Simulasi response dari FCM
        $response = [
            'success' => true,
            'message_id' => 'msg_' . uniqid(),
            'student_token' => 'simulated_token_' . $studentId,
        ];

        Log::info('Push Notification Response (Simulated)', $response);

        return $response['success'];
    }

    /**
     * Send attendance confirmation notification
     *
     * @param int $studentId
     * @param string $status
     * @param string $time
     * @return bool
     */
    public function sendAttendanceConfirmation($studentId, $status, $time)
    {
        $title = 'Konfirmasi Presensi';
        $message = "Presensi {$status} berhasil dicatat pada {$time}";

        $data = [
            'type' => 'attendance_confirmation',
            'status' => $status,
            'time' => $time,
        ];

        return $this->sendNotification($studentId, $title, $message, $data);
    }

    /**
     * Send check-in reminder notification
     *
     * @param int $studentId
     * @return bool
     */
    public function sendCheckInReminder($studentId)
    {
        $title = 'Pengingat Absen Masuk';
        $message = 'Jangan lupa untuk melakukan absen masuk hari ini!';

        $data = [
            'type' => 'checkin_reminder',
            'reminder_type' => 'checkin',
        ];

        return $this->sendNotification($studentId, $title, $message, $data);
    }

    /**
     * Send check-out reminder notification
     *
     * @param int $studentId
     * @return bool
     */
    public function sendCheckOutReminder($studentId)
    {
        $title = 'Pengingat Absen Pulang';
        $message = 'Jangan lupa untuk melakukan absen pulang hari ini!';

        $data = [
            'type' => 'checkout_reminder',
            'reminder_type' => 'checkout',
        ];

        return $this->sendNotification($studentId, $title, $message, $data);
    }

    /**
     * Send bulk notifications to multiple students
     *
     * @param array $studentIds
     * @param string $title
     * @param string $message
     * @param array $data
     * @return array
     */
    public function sendBulkNotifications($studentIds, $title, $message, $data = [])
    {
        $results = [];

        foreach ($studentIds as $studentId) {
            $results[$studentId] = $this->sendNotification($studentId, $title, $message, $data);
        }

        return $results;
    }
}