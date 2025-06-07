<h2>Gửi email từ template</h2>

<form method="POST" action="{{ route('mail.send') }}">
    @csrf

    <label>Email người nhận:</label><br>
    <input name="email" type="email" required><br><br>

    <label>Chọn template:</label><br>
    <select name="template_id" required>
            <option value="">hãy chọn</option>
        @foreach ($templates as $template)
            <option value="{{ $template->template_id }}">{{ $template->template_name }}</option>
        @endforeach
    </select><br><br>

    <button type="submit">Gửi email</button>
</form>
