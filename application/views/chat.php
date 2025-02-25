<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        .chat-box {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            background: #f9f9f9;
        }
        .chat-message {
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            max-width: 75%;
        }
        .sent {
            background: #007bff;
            color: white;
            align-self: flex-end;
        }
        .received {
            background: #e9ecef;
            color: black;
            align-self: flex-start;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">My Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('chat/index') ?>">chat</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

	<div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="text-center">Welcome to the Dashboard</h3>
            <p class="text-center">Hello, <?= $this->session->userdata('username'); ?>!</p>
        </div>
    </div>

	<div class="container mt-4">
        <div class="row">
            <!-- User List -->
			<div class="col-md-4">
            <div class="card">
				<div class="card-header bg-primary text-white">Users</div>
				<ul class="list-group list-group-flush" id="user-list">
					<?php foreach ($users as $user): ?>
						<li class="list-group-item d-flex justify-content-between align-items-center user-item" data-user-id="<?= $user->id ?>">
							<?= $user->username ?>
							<span class="badge bg-danger unread-count" id="unread-<?= $user->id ?>" style="display: none;">0</span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		   </div>

            <!-- Chat Box -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white" id="chat-header">Select a user to chat</div>
                    <div class="card-body" id="chat-box" style="height: 400px; overflow-y: auto;"></div>
                    <div class="card-footer">
                        <form id="chat-form" class="d-flex">
                            <input type="hidden" id="receiver_id">
                            <input type="text" id="message" class="form-control me-2" placeholder="Type a message..." required>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let receiverId = null;
        let userId = <?= $this->session->userdata('user_id'); ?>;
		let messageInterval, unreadInterval;

		 // Load the notification sound
		 let notificationSound = new Audio("<?= base_url('assets/sound/notifications.mp3'); ?>");

		// Auto-fetch messages every 3 seconds
		function autoFetchMessages() {
			if (!receiverId) return;
			fetchMessages();
		}

		function startIntervals() {
        // Clear any existing intervals before starting new ones
			clearInterval(messageInterval);
			clearInterval(unreadInterval);

			// Start new intervals
			messageInterval = setInterval(autoFetchMessages, 3000);
			unreadInterval = setInterval(fetchUnreadCounts, 5000);
		}

		// Load unread message counts on page load
		function fetchUnreadCounts() {
			fetch("<?= base_url('chat/get_unread_notifications') ?>")
			.then(response => response.json())
			.then(data => {
				document.querySelectorAll('.unread-count').forEach(el => el.style.display = 'none');
				
				data.forEach(item => {
					let badge = document.getElementById("unread-" + item.sender_id);
					if (badge) {
						badge.textContent = item.unread_count;
						badge.style.display = 'inline-block';
					}
				});
			});
		}
        
        // Select User to Chat
        document.querySelectorAll('.user-item').forEach(item => {
            item.addEventListener('click', function() {
                receiverId = this.getAttribute('data-user-id');
                document.getElementById('receiver_id').value = receiverId;
                // Remove unread count badge from the username
                let username = this.textContent.replace(/\d+/, '').trim();
                document.getElementById('chat-header').textContent = 'Chat with ' + username;
                document.getElementById('chat-box').innerHTML = ''; // Clear previous messages

				 // Remove unread badge when chat is opened
				 fetch("<?= base_url('chat/mark_as_read') ?>", {
					method: "POST",
					body: new URLSearchParams({ sender_id: receiverId }),
					headers: { "Content-Type": "application/x-www-form-urlencoded" }
				}).then(()=>startIntervals());

            });
        });

		function fetchMessages() {
         if (!receiverId) return;
			fetch("<?= base_url('chat/get_messages') ?>", {
				method: "POST",
				body: new URLSearchParams({ receiver_id: receiverId }),
				headers: { "Content-Type": "application/x-www-form-urlencoded" }
			})
			.then(response => response.json())
			.then(messages => {
				let chatBox = document.getElementById("chat-box");
				let lastMessageCount = chatBox.childElementCount;
				chatBox.innerHTML = ''; // Clear previous messages

				messages.forEach(message => {
					let newMessage = document.createElement("div");
					let sender = message.sender_id == userId ? "You" : message.sender_name;
					newMessage.innerHTML = `<strong>${sender}:</strong> ${message.message}`;
					newMessage.classList.add("chat-message", message.sender_id == userId ? "sent" : "received");
					chatBox.appendChild(newMessage);
				});

				chatBox.scrollTop = chatBox.scrollHeight;

				// Play sound only if a new message was received
				if (messages.length > lastMessageCount) {
               	 notificationSound.play();
            	}
			});
		}

        // Send Message
        document.getElementById("chat-form").addEventListener("submit", function(event) {
            event.preventDefault();
            let messageInput = document.getElementById("message");
            let message = messageInput.value.trim();
            if (message === "" || !receiverId) return alert('Silahkan Pilih User Terlebih dahulu');

            fetch("<?= base_url('chat/send_message') ?>", {
                method: "POST",
                body: new URLSearchParams({ receiver_id: receiverId, message: message }),
                headers: { "Content-Type": "application/x-www-form-urlencoded" }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    let chatBox = document.getElementById("chat-box");
                    let newMessage = document.createElement("div");
                    newMessage.innerHTML = `<strong>You:</strong> ${message}`;
                    newMessage.classList.add("chat-message", "sent");
                    chatBox.appendChild(newMessage);
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
                messageInput.value = "";
            });
        });

        // Pusher Configuration
        var pusher = new Pusher("<?= $this->config->item('pusher_key'); ?>", {
            cluster: "<?= $this->config->item('pusher_cluster'); ?>",
            encrypted: true
        });

        var channel = pusher.subscribe("private-chat-" + userId);
        channel.bind("new_message", function(data) {
            if (data.sender_id == receiverId || data.receiver_id == userId) {
                fetchMessages();
            }
        });

		window.addEventListener('beforeunload', function () {
			clearInterval(messageInterval);
			clearInterval(unreadInterval);
		});

		document.addEventListener("visibilitychange", function() {
			if (document.hidden) {
				clearInterval(messageInterval);
				clearInterval(unreadInterval);
			} else {
				startIntervals();
			}
		});

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
