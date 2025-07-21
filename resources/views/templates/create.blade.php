<h2>Tạo Email Template</h2>

<form method="POST" action="{{ route('template.store') }}">
    @csrf

    <label>Tiêu đề:</label><br>
    <input name="template_name" value="{{ old('template_name') }}"><br>

    <label>Subject:</label><br>
    <input name="subject" value="{{ old('subject') }}"><br>

    <label>Nội dung HTML:</label><br>
    <textarea name="content" rows="10">{{ old('content') }}</textarea><br>

    <button type="submit">Lưu</button>
</form>