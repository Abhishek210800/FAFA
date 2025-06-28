<!-- Chatbot Popup -->
<div id="chatbotModal" class="hidden fixed bottom-20 right-6 w-80 bg-white rounded-xl shadow-lg p-4 z-50 border border-gray-300">
    <h3 class="text-lg font-semibold mb-2">Support Chatbot</h3>
    <form id="chatForm" method="POST" action="{{ route('support.store') }}">
        @csrf
        <div class="mb-2">
            <label class="block text-sm font-medium">Your Name</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded px-2 py-1" id="userName" required>
        </div>
        <div class="mb-2">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" class="w-full border border-gray-300 rounded px-2 py-1" id="userEmail" required>
        </div>
        <div class="mb-2">
            <label class="block text-sm font-medium">Issue Type</label>
            <select name="issue_type" id="issueType" class="w-full border border-gray-300 rounded px-2 py-1">
                <option value="Case Update">Case Update</option>
                <option value="Document Upload">Document Upload</option>
                <option value="Login Issue">Login Issue</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-2">
            <label class="block text-sm font-medium">Message</label>
            <textarea name="message" class="w-full border border-gray-300 rounded px-2 py-1" id="userMessage" rows="3" required></textarea>
        </div>
        <div class="text-right">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded">Send</button>
        </div>
    </form>

</div>


<script>
    document.querySelector("#chatbotToggle").addEventListener("click", function () {
        document.getElementById("chatbotModal").classList.toggle("hidden");
    });
</script>
