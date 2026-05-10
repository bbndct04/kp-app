<x-app-layout>
    <x-slot name="title">Notifications</x-slot>
    <x-slot name="header">Notifications</x-slot>

    <div style="max-width:700px;margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <p style="font-size:13.5px;color:#64748b;">Updates about your complaints</p>
            @if($notifications->where('is_read', false)->count() > 0)
            <span style="background:#fee2e2;color:#991b1b;font-size:12px;font-weight:600;padding:4px 12px;border-radius:99px;">
                {{ $notifications->where('is_read', false)->count() }} unread
            </span>
            @endif
        </div>

        @if($notifications->isEmpty())
        <div class="card" style="padding:52px;text-align:center;">
            <div style="font-size:40px;margin-bottom:12px;">🔔</div>
            <div style="font-size:15px;font-weight:600;color:#1e2d5e;margin-bottom:6px;">No notifications yet</div>
            <div style="font-size:13px;color:#94a3b8;">You'll be notified here when your complaint status changes.</div>
        </div>
        @else

        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($notifications as $notif)
            @php
                $colors = [
                    'success' => ['bg'=>'#d1fae5','border'=>'#6ee7b7','icon'=>'#059669'],
                    'warning' => ['bg'=>'#fef3c7','border'=>'#fcd34d','icon'=>'#d97706'],
                    'danger'  => ['bg'=>'#fee2e2','border'=>'#fca5a5','icon'=>'#dc2626'],
                    'info'    => ['bg'=>'#e0f2fe','border'=>'#7dd3fc','icon'=>'#0284c7'],
                ];
                $c = $colors[$notif->type] ?? $colors['info'];
            @endphp
            <div style="background:#fff;border-radius:12px;border:1.5px solid {{ $notif->is_read ? '#e5e9f0' : $c['border'] }};padding:16px 18px;display:flex;gap:14px;align-items:flex-start;{{ $notif->is_read ? '' : 'background:' . $c['bg'] . ';' }}">

                {{-- Icon --}}
                <div style="width:40px;height:40px;border-radius:10px;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1.5px solid {{ $c['border'] }};">
                    @if($notif->type === 'success')
                        <svg width="18" height="18" fill="none" stroke="{{ $c['icon'] }}" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    @elseif($notif->type === 'danger')
                        <svg width="18" height="18" fill="none" stroke="{{ $c['icon'] }}" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    @elseif($notif->type === 'warning')
                        <svg width="18" height="18" fill="none" stroke="{{ $c['icon'] }}" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    @else
                        <svg width="18" height="18" fill="none" stroke="{{ $c['icon'] }}" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    @endif
                </div>

                {{-- Content --}}
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:4px;">
                        <div style="font-size:14px;font-weight:700;color:#1e2d5e;">{{ $notif->title }}</div>
                        @if(!$notif->is_read)
                        <span style="background:#dc2626;width:8px;height:8px;border-radius:50%;flex-shrink:0;display:block;"></span>
                        @endif
                    </div>
                    <div style="font-size:13px;color:#475569;line-height:1.6;margin-bottom:8px;">{{ $notif->message }}</div>
                    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                        <div style="font-size:12px;color:#94a3b8;">
                            {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                        </div>
                        @if($notif->complaint_id)
                        <a href="{{ route('track') }}?ref={{ $notif->complaint->reference_number ?? '' }}"
                            style="font-size:12px;font-weight:600;color:#3554a0;text-decoration:none;padding:4px 12px;border-radius:6px;border:1px solid #c5d5f0;background:#e8eef8;">
                            Track Complaint →
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @endif
    </div>
</x-app-layout>