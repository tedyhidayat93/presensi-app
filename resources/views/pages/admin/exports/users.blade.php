<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Karyawan</th>
        <th>NIP</th>
        <th>NIK</th>
        <th>Jenis Kelamin</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Jabatan</th>
    </tr>
    </thead>
    <tbody>
        @php
            $no =1;
        @endphp
    @foreach($users as $user)
        <tr>
            <td>{{$no++}}</td>
            <td>{{ $user->full_name ?? '-' }}</td>
            <td>{{ $user->nip ?? '-' }}</td>
            <td>{{ $user->nik ?? '-' }}</td>
            <td>{{ $user->gender ?? '-' }}</td>
            <td>{{ $user->email ?? '-' }}</td>
            <td>{{ $user->phone ?? '-' }}</td>
            <td>{{ $user->jabatan->type ?? '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>