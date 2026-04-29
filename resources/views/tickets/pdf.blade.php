<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tiket {{ $ticket->ticket_code }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 28px;
            color: #0f172a;
            font-size: 12px;
            background: #f8fafc;
        }

        .sheet {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
        }

        .header {
            padding: 28px 32px 20px;
            background: #fff7ed;
            border-bottom: 1px solid #fed7aa;
        }

        .eyebrow {
            margin: 0 0 8px;
            font-size: 11px;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            color: #9a3412;
        }

        .event-name {
            margin: 0;
            font-size: 28px;
            line-height: 1.2;
            font-weight: bold;
            color: #111827;
        }

        .event-meta {
            margin-top: 12px;
            color: #475569;
            font-size: 12px;
        }

        .event-meta span {
            margin-right: 14px;
        }

        .content {
            padding: 28px 32px 32px;
        }

        .qr-section {
            margin-bottom: 28px;
            text-align: center;
            padding: 26px 24px;
            border: 1px solid #cbd5e1;
            border-radius: 18px;
            background: #f8fafc;
        }

        .qr-code img {
            width: 210px;
            height: 210px;
        }

        .manual-label {
            margin-top: 14px;
            font-size: 10px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: #64748b;
        }

        .ticket-code {
            margin-top: 8px;
            font-size: 24px;
            line-height: 1.2;
            font-weight: bold;
            letter-spacing: 0.8px;
            color: #0f172a;
        }

        .manual-note {
            margin-top: 8px;
            color: #64748b;
            font-size: 11px;
        }

        .section-title {
            margin: 0 0 14px;
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #64748b;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .summary td {
            width: 50%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
        }

        .summary-label {
            display: block;
            margin-bottom: 4px;
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }

        .members-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
        }

        .members-table th {
            padding: 12px 10px;
            background: #111827;
            color: #ffffff;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .members-table td {
            padding: 11px 10px;
            border-top: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .members-table tr:nth-child(even) td {
            background: #f8fafc;
        }

        .member-primary {
            display: inline-block;
            margin-left: 6px;
            padding: 2px 8px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 18px;
            color: #475569;
            font-size: 11px;
            line-height: 1.7;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="header">
            <p class="eyebrow">E-Ticket Event</p>
            <h1 class="event-name">{{ $ticket->event?->name ?: 'Event' }}</h1>
            <div class="event-meta">
                <span>{{ optional($ticket->event?->event_date)->translatedFormat('d F Y') ?? 'Tanggal belum diatur' }}</span>
                <span>{{ $ticket->event?->venue_name ?: 'Lokasi belum diatur' }}</span>
            </div>
        </div>

        <div class="content">
            <div class="qr-section">
                <div class="qr-code">
                    <img src="{{ $qrImageSrc }}" alt="QR Code Tiket">
                </div>
                <div class="manual-label">Kode Tiket Untuk Input Manual</div>
                <div class="ticket-code">{{ $ticket->ticket_code }}</div>
                <div class="manual-note">Tunjukkan QR code ini saat check-in. Jika scanner bermasalah, petugas bisa memasukkan kode tiket secara manual.</div>
            </div>

            <h2 class="section-title">Ringkasan Tiket</h2>
            <table class="summary">
                <tr>
                    <td>
                        <span class="summary-label">Kode Keluarga</span>
                        <span class="summary-value">{{ $ticket->family?->family_code ?: '-' }}</span>
                    </td>
                    <td>
                        <span class="summary-label">Kuota Digunakan</span>
                        <span class="summary-value">{{ $ticket->quota_used }}/{{ $ticket->quota_total }}</span>
                    </td>
                </tr>
            </table>

            <h2 class="section-title">Detail Anggota</h2>
            <table class="members-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">No</th>
                        <th style="width: 32%;">Nama</th>
                        <th style="width: 18%;">Tipe</th>
                        <th style="width: 20%;">Hubungan</th>
                        <th style="width: 12%;">Kelas</th>
                        <th style="width: 10%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticket->family?->members ?? [] as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $member->name }}
                                @if ($member->is_primary_student)
                                    <span class="member-primary">Siswa Utama</span>
                                @endif
                            </td>
                            <td>{{ \App\Support\EnumOptions::label($member->member_type) }}</td>
                            <td>{{ $member->relation_label ?: '-' }}</td>
                            <td>{{ $member->class_name ?: '-' }}</td>
                            <td>{{ $member->is_registered_member ? 'Terdaftar' : 'Nonaktif' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada data anggota keluarga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="footer">
                Tiket ini hanya berlaku untuk event di atas dan mengikuti data anggota yang terdaftar pada sistem.
                Pastikan nama anggota sesuai sebelum proses check-in dilakukan.
            </div>
        </div>
    </div>
</body>
</html>
