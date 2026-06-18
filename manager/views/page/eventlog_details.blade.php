@extends('manager::template.page')
@section('content')
    @push('scripts.top')
        <script type="text/javascript">
            var actions = {
                // 116 = event delete processor
                delete: function() {
                    if (confirm("{{ ManagerTheme::getLexicon('confirm_delete_eventlog') }}") === true) {
                        document.location.href = "index.php?id=" + document.resource.id.value + "&a=116";
                    }
                },
                // 114 = list events
                cancel: function() {
                    documentDirty = false;
                    document.location.href = 'index.php?a=114';
                }
            };
        </script>
    @endpush

    <h1>
        {{ ManagerTheme::getLexicon('eventlog') }}
    </h1>

    {!! ManagerTheme::getStyle('actionbuttons.dynamic.canceldelete') !!}

    <?php /** @var EvolutionCMS\Models\EventLog $log */?>
    @if ($log->exists)
        <form name="resource" method="get">
            <input type="hidden" name="id" value="{{ $log->getKey() }}" />
            <input type="hidden" name="a" value="{{ $controller->getIndex() }}" />
            <input type="hidden" name="listmode" value="{{ get_by_key($_REQUEST, 'listmode') }}" />
            <input type="hidden" name="op" value="" />
            <div class="tab-page">
                <div class="container container-body">
                    <table class="table data">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    @switch($log->type)
                                        @case(EvolutionCMS\Models\EventLog::TYPE_INFORMATION)
                                            <i class="{{ $_style['icon_info_circle'] }} text-info"></i>
                                            {{ ManagerTheme::getLexicon('information') }}
                                        @break

                                        @case(EvolutionCMS\Models\EventLog::TYPE_WARNING)
                                            <i class="{{ $_style['icon_info_triangle'] }} text-warning"></i>
                                            {{ ManagerTheme::getLexicon('warning') }}
                                        @break

                                        @case(EvolutionCMS\Models\EventLog::TYPE_ERROR)
                                            <i class="{{ $_style['icon_ban'] }} text-danger"></i>
                                            {{ ManagerTheme::getLexicon('error') }}
                                        @break

                                        @default
                                            :
                                            <p>N/A</p>
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ ManagerTheme::getLexicon('event_id') }}</th>
                                <td>{{ $log->eventid }}</td>
                            </tr>
                            <tr>
                                <th>{{ ManagerTheme::getLexicon('source') }}</th>
                                <td>{{ $log->source }}</td>
                            </tr>
                            <tr>
                                <th>{{ ManagerTheme::getLexicon('date') }}</th>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>{{ ManagerTheme::getLexicon('user') }}</th>
                                <td>{{ $log->getUser() !== null ? $log->getUser()->username : '-' }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">{!! $log->description !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    @endif
@endsection
