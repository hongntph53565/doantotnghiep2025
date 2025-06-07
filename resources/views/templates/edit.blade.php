<form method="POST" action="{{ route('templates.update', $template->template_id) }}">
    @csrf
    @method('PUT')

    <label>Tiêu đề:</label><br>
    <input name="template_name" value="{{ old('template_name', $template->template_name) }}"><br>

    <label>Subject:</label><br>
    <input name="subject" value="{{ old('subject', $template->subject) }}"><br>

    <label>Nội dung HTML:</label><br>
    <textarea name="content" rows="10">{{ old('content', $template->content) }}</textarea><br>

    <button type="submit">Cập nhật</button>
</form>
