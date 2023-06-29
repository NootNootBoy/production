<?php 
    function createNotification($icon, $title, $description) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO notifications (icon, title, description) VALUES (?, ?, ?)');
        $stmt->execute([$icon, $title, $description]);
        return $pdo->lastInsertId();
    }

    function assignNotificationToUser($notificationId, $userId) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO notification_user (notification_id, user_id) VALUES (?, ?)');
        $stmt->execute([$notificationId, $userId]);
    }

    function markNotificationAsRead($notificationId, $userId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE notification_user SET `read` = TRUE WHERE notification_id = ? AND user_id = ?');
        $stmt->execute([$notificationId, $userId]);
    }

    function getNotificationsForUser($userId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT n.id, n.icon, n.title, n.description, n.timestamp, nu.read FROM notifications n JOIN notification_user nu ON n.id = nu.notification_id WHERE nu.user_id = ? AND nu.read = FALSE ORDER BY n.timestamp DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    function getUnreadNotificationCount($userId) {
        global $pdo;
    
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND read = 0");
        $stmt->execute([$userId]);
    
        return $stmt->fetchColumn();
    }

    function send_notification($pdo, $title, $description, $icon, $user_id, $rang) {
        // Créer une nouvelle notification
        $notificationId = createNotification($icon, $title, $description);
    
        // Si un rang spécifique est défini, assigner la notification à tous les utilisateurs de ce rang
        if ($rang !== null) {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE rang = ?');
            $stmt->execute([$rang]);
            $users = $stmt->fetchAll();
    
            foreach ($users as $user) {
                assignNotificationToUser($notificationId, $user['id']);
            }
        }
        // Sinon, assigner la notification à l'utilisateur spécifié
        else {
            assignNotificationToUser($notificationId, $user_id);
        }
    }
?>