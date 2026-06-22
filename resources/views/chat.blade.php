<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        #chat-box::-webkit-scrollbar { width: 4px; }
        #chat-box::-webkit-scrollbar-track { background: transparent; }
        #chat-box::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }

        .chat-load {
            opacity: 0;
            transform: translateY(25px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .chat-loaded {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-[#F4F7F6] h-screen flex flex-col overflow-hidden">

    <div class="bg-white px-6 py-4 shadow-sm border-b border-gray-100 flex items-center z-10">
        <a href="javascript:history.back()" class="w-10 h-10 rounded-xl flex items-center justify-center text-[#2D433E] hover:bg-gray-50 mr-2 transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="flex items-center gap-3">
            <div class="relative">
                <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($provider->nama ?? 'default') }}" class="w-11 h-11 rounded-[18px] object-cover border-2 border-white shadow-sm">
                <div id="online-indicator" class="absolute bottom-0 right-0 w-3 h-3 bg-gray-300 border-2 border-white rounded-full transition-all duration-500"></div>
            </div>
            <div>
                <h3 class="font-bold text-[#2D433E] text-sm leading-none">{{ $provider->nama ?? 'Penyedia Jasa' }}</h3>
                <p id="status-text" class="text-[10px] text-gray-400 font-bold uppercase mt-1 tracking-wider">Menghubungkan...</p>
            </div>
        </div>
    </div>
<input type="hidden" id="penerima-id" value="{{ $id_sitter ?? 0 }}">
    <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-4 flex flex-col chat-load">
        <div class="flex items-start gap-3">
            <div class="bg-white p-4 rounded-tr-[22px] rounded-bl-[22px] rounded-br-[22px] shadow-sm border border-gray-50 max-w-[85%]">
                <p class="text-sm text-[#2D433E] leading-relaxed">Halo! Selamat datang di layanan chat GoPet. Ada yang bisa saya bantu hari ini? 😊</p>
                <p class="text-[9px] text-gray-300 mt-2 text-right">08:00</p>
            </div>
        </div>

        @foreach($messages ?? [] as $msg)
            @php
              $isSender = ($msg->id_pengirim == Auth::id());
              $time = \Carbon\Carbon::parse($msg->created_at)->format('H:i');
            @endphp
            @if($isSender)
                <div class="flex flex-row-reverse items-start gap-3 msg-bubble" data-msg-id="{{ $msg->id }}">
                    <div class="bg-[#2D433E] p-4 rounded-tl-[22px] rounded-bl-[22px] rounded-br-[22px] shadow-md shadow-[#2D433E]/10 max-w-[85%]">
                        <p class="text-sm text-white leading-relaxed">{{ $msg->isi_pesan }}</p>
                        <p class="text-[9px] text-white/50 mt-2 text-right">{{ $time }}</p>
                    </div>
                </div>
            @else
                <div class="flex items-start gap-3 msg-bubble" data-msg-id="{{ $msg->id }}">
                    <div class="bg-white p-4 rounded-tr-[22px] rounded-bl-[22px] rounded-br-[22px] shadow-sm border border-gray-50 max-w-[85%]">
                        <p class="text-sm text-[#2D433E] leading-relaxed">{{ $msg->isi_pesan }}</p>
                        <p class="text-[9px] text-gray-300 mt-2 text-right">{{ $time }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="bg-white p-4 pb-8 border-t border-gray-50 shadow-[0_-10px_40px_rgba(0,0,0,0.02)]">
        <div class="max-w-4xl mx-auto flex items-center gap-2 bg-[#F8FBF0] p-2 rounded-[25px] border border-[#5E887E]/10">
            <label class="w-11 h-11 flex items-center justify-center text-gray-400 hover:text-[#5E887E] cursor-pointer transition-colors">
                <input type="file" class="hidden" id="file-input">
                <i class="fas fa-paperclip text-lg"></i>
            </label>

            <input type="text" id="message-input" placeholder="Tulis pesan ke {{ $provider->nama ?? 'Penyedia Jasa' }}..."
                class="flex-1 bg-transparent border-none focus:ring-0 outline-none text-sm text-[#2D433E] px-2 font-medium">

            <button onclick="sendMessage()" class="w-11 h-11 bg-[#2D433E] text-white rounded-full flex items-center justify-center hover:bg-[#5E887E] transition-all shadow-lg active:scale-90">
                <i class="fas fa-paper-plane text-xs"></i>
            </button>
        </div>
    </div>

    <script>
        const messageInput = document.getElementById('message-input');
        const chatBox = document.getElementById('chat-box');
        const statusText = document.getElementById('status-text');
        const onlineIndicator = document.getElementById('online-indicator');
        const receiverId = document.getElementById('penerima-id').value;
        const currentUserId = {{ Auth::id() ?? 0 }};

        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                chatBox.classList.add('chat-loaded');
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 50);

            // Start polling every 3 seconds
            setInterval(pollMessages, 3000);
        });

        setTimeout(() => {
            statusText.innerText = "Online";
            statusText.classList.replace('text-gray-400', 'text-[#5E887E]');
            onlineIndicator.classList.replace('bg-gray-300', 'bg-green-500');
        }, 1500);

        function sendMessage() {
            const text = messageInput.value.trim();
            if (text === "") return;

            fetch('/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id_penerima: receiverId,
                    isi_pesan: text
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Poll immediately to grab the new message
                    pollMessages();
                    messageInput.value = "";
                } else {
                    alert('Gagal mengirim pesan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function pollMessages() {
            const bubbles = document.querySelectorAll('.msg-bubble');
            let lastId = 0;
            if (bubbles.length > 0) {
                lastId = bubbles[bubbles.length - 1].dataset.msgId;
            }

            fetch(`/chat/get-messages/${receiverId}?last_id=${lastId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        const isSender = msg.id_pengirim == currentUserId;
                        const date = new Date(msg.created_at);
                        const time = date.getHours().toString().padStart(2, '0') + ":" + date.getMinutes().toString().padStart(2, '0');
                        let bubble = '';
                        if (isSender) {
                            bubble = `
                                <div class="flex flex-row-reverse items-start gap-3 msg-bubble" data-msg-id="${msg.id}">
                                    <div class="bg-[#2D433E] p-4 rounded-tl-[22px] rounded-bl-[22px] rounded-br-[22px] shadow-md shadow-[#2D433E]/10 max-w-[85%]">
                                        <p class="text-sm text-white leading-relaxed">${msg.isi_pesan}</p>
                                        <p class="text-[9px] text-white/50 mt-2 text-right">${time}</p>
                                    </div>
                                </div>
                            `;
                        } else {
                            bubble = `
                                <div class="flex items-start gap-3 msg-bubble" data-msg-id="${msg.id}">
                                    <div class="bg-white p-4 rounded-tr-[22px] rounded-bl-[22px] rounded-br-[22px] shadow-sm border border-gray-50 max-w-[85%]">
                                        <p class="text-sm text-[#2D433E] leading-relaxed">${msg.isi_pesan}</p>
                                        <p class="text-[9px] text-gray-300 mt-2 text-right">${time}</p>
                                    </div>
                                </div>
                            `;
                        }
                        chatBox.innerHTML += bubble;
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            })
            .catch(err => console.error(err));
        }

        messageInput.addEventListener("keypress", (e) => {
            if (e.key === "Enter") sendMessage();
        });

        document.getElementById('file-input').addEventListener('change', function() {
            if(this.files[0]) {
                alert("File '" + this.files[0].name + "' terpilih! (Simulasi kirim gambar)");
            }
        });
    </script>

</body>
</html>
