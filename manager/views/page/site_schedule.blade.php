<?php

use EvolutionCMS\Facades\ManagerTheme;

?>
@extends('manager::template.page')
@section('content')
    @push('scripts.top')
        <script src="media/script/tablesort.js"></script>
        <script>
            window.addEventListener('load', () => {
                evo.collapse('.panel-heading', 'panel-collapse');
            });
        </script>
    @endpush
    <h1>
        <i class="{{ ManagerTheme::getStyle('icon_calendar') }}"></i> {{ __('global.site_schedule') }}
    </h1>

    <div class="tab-page">
        <div class="container container-body">
            <div class="clearfix"></div>
            <div class="panel-group no-transition">
                <div class="resourceTable panel panel-default list">
                    <div class="panel-heading">
                        <span class="panel-title">
                            <a class="accordion-toggle" role="button" href="#schedulePublished"><i class="fa fa-fw"></i>
                                <span
                                    class="category_name"><strong>{{ __('global.publish_events') }}</strong></span></a>
                        </span>
                    </div>
                    <div class="panel-collapse">
                        @if ($publishedDocs->count() === 0)
                            <p>{{ __('global.no_docs_pending_publishing') }}</p>
                        @else
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table data">
                                        <thead>
                                            <tr>
                                                <th class="sortable" style="width: 1%">{{ __('global.id') }}
                                                </th>
                                                <th class="sortable">{{ __('global.resource') }}</th>
                                                <th class="sortable text-right" style="width: 15%">
                                                    {{ __('global.publish_date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($publishedDocs as $row)
                                                <?php /** @var EvolutionCMS\Models\SiteContent $row */ ?>
                                                <tr>
                                                    <td class="text-right">{{ $row->getKey() }}</td>
                                                    <td><a
                                                            href="{{ $row->makeUrl('actions.info') }}">{{ $row->nodeName }}</a>
                                                    </td>
                                                    <td class="text-nowrap text-right">{{ $row->pub_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="panel-heading">
                        <span class="panel-title">
                            <a class="accordion-toggle" role="button" href="#scheduleUnpublished"><i class="fa fa-fw"></i>
                                <span
                                    class="category_name"><strong>{{ __('global.unpublish_events') }}</strong></span></a>
                        </span>
                    </div>
                    <div class="panel-collapse">
                        @if ($unpublishedDocs->count() === 0)
                            <p>{{ __('global.no_docs_pending_unpublishing') }}</p>
                        @else
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table data">
                                        <thead>
                                            <tr>
                                                <th class="sortable" style="width: 1%">{{ __('global.id') }}
                                                </th>
                                                <th class="sortable">{{ __('global.resource') }}</th>
                                                <th class="sortable text-right" style="width: 15%">
                                                    {{ __('global.unpublish_date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($unpublishedDocs as $row)
                                                <?php /** @var EvolutionCMS\Models\SiteContent $row */ ?>
                                                <tr>
                                                    <td class="text-right">{{ $row->getKey() }}</td>
                                                    <td><a
                                                            href="{{ $row->makeUrl('actions.info') }}">{{ $row->nodeName }}</a>
                                                    </td>
                                                    <td class="text-nowrap text-right">{{ $row->unPub_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="panel-heading">
                        <span class="panel-title">
                            <a class="accordion-toggle" role="button" href="#scheduleAll"><i class="fa fa-fw"></i> <span
                                    class="category_name"><strong>{{ __('global.all_events') }}</strong></span></a>
                        </span>
                    </div>
                    <div class="panel-collapse">
                        @if ($allDocs->count() === 0)
                            <p>{{ __('global.no_docs_pending_pubunpub') }}</p>
                        @else
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table data">
                                        <thead>
                                            <tr>
                                                <th class="sortable" style="width: 1%">{{ __('global.id') }}
                                                </th>
                                                <th class="sortable">{{ __('global.resource') }}</th>
                                                <th class="sortable text-right" style="width: 15%">
                                                    {{ __('global.publish_date') }}</th>
                                                <th class="sortable text-right" style="width: 15%">
                                                    {{ __('global.unpublish_date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allDocs as $row)
                                                <?php /** @var EvolutionCMS\Models\SiteContent $row */ ?>
                                                <tr>
                                                    <td class="text-right">{{ $row->getKey() }}</td>
                                                    <td><a
                                                            href="{{ $row->makeUrl('actions.info') }}">{{ $row->nodeName }}</a>
                                                    </td>
                                                    <td class="text-nowrap text-right">{{ $row->pub_at ?? '-' }}</td>
                                                    <td class="text-nowrap text-right">{{ $row->unPub_at ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
