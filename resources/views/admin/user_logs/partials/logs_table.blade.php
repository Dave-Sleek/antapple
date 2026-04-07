{{-- CORRECT: partial returns only rows --}}
@foreach ($logs as $log)
    @php
        $isAttack = Str::contains($log->endpoint, ['.env', 'wp-admin', 'phpmyadmin', 'vendor', 'storage']);
        $user = App\Models\User::find($log->user_id);
        $initials = $user ? substr($user->name, 0, 1) : '?';
    @endphp

    <tr class="{{ $isAttack ? 'table-danger' : '' }} log-row">
        <td>
            <div class="user-info">
                <div class="user-avatar">
                    <span class="avatar-initials">{{ $initials }}</span>
                </div>
                <div>
                    <div class="user-name">{{ $user->name ?? 'Unknown User' }}</div>
                    <div class="user-id">ID: {{ $log->user_id }}</div>
                </div>
            </div>
        </td>
        <td>
            <div class="ip-info">
                <i class="bi bi-ip"></i>
                <span class="ip-address">{{ $log->ip_address }}</span>
                <span class="location-badge" title="Approximate location">
                    <i class="bi bi-geo-alt"></i>
                    {{ getLocationFromIP($log->ip_address) ?? 'Unknown' }}
                </span>
            </div>
        </td>
        <td>
            @if ($isAttack)
                <i class="bi bi-exclamation-triangle text-danger me-1"></i>
            @endif
            {{ $log->endpoint }}
        </td>
        <td>
            @php
                $methodColors = [
                    'GET' => ['bg' => '#d1fae5', 'text' => '#047857'],
                    'POST' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                    'PUT' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                    'DELETE' => ['bg' => '#fee2e2', 'text' => '#b91c1c'],
                ];
                $color = $methodColors[$log->method] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
            @endphp
            <span class="badge" style="background-color: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                {{ $log->method }}
            </span>
        </td>
        <td>
            <div class="device-info">
                <i class="bi bi-{{ getDeviceIcon($log->user_agent) }}"></i>
                <span class="device-type">{{ getDeviceType($log->user_agent) }}</span>
                <span class="browser small">{{ getBrowser($log->user_agent) }}</span>
            </div>
        </td>
        <td>
            <div class="timestamp">
                <span class="date">{{ $log->created_at->format('M d, Y') }}</span>
                <span class="time">{{ $log->created_at->format('h:i:s A') }}</span>
                <span class="time-ago">{{ $log->created_at->diffForHumans() }}</span>
            </div>
        </td>
    </tr>
@endforeach
