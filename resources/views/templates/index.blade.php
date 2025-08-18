<h2>Danh sách Email Templates</h2>

<a href="{{ route('template.create') }}">➕ Tạo mới</a>

@if(session('success'))
    <div style="color: green">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Subject</th>
        <th>Thao tác</th>
    </tr>
    @foreach ($templates as $template)
        <tr>
            <td>{{ $template->template_id }}</td>
            <td>{{ $template->template_name }}</td>
            <td>{{ $template->subject }}</td>
            <td>
                <a href="{{ route('template.edit', $template) }}">✏️</a>
                <form action="{{ route('template.delete', $template) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Xoá template này?')">🗑️</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
