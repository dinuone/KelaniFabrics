<!DOCTYPE html>
<html>
<head>
    <title>Sub Category Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #f0f0f0;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-inactive {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Sub Category Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Sub Category Name</th>
                <th>Parent Category</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sub_categories as $index => $sub_category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sub_category->sub_cat_name }}</td>
                    <td>{{ $sub_category->category->cat_name ?? '-' }}</td>
                    <td>
                        @if($sub_category->sub_cat_status == \App\Enums\StatusEnum::ACTIVE)
                            <span class="status-active">Active</span>
                        @else
                            <span class="status-inactive">Inactive</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
