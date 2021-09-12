@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => 'yyyyy',
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];

	$studentCount = App\Models\Student::count();
 
	Widget::add()->to('before_content')->type('div')->class('row')->content([
		Widget::make()
			->type('progress')
			->class('card border-0 text-white bg-primary')
			->progressClass('progress-bar')
			->value($studentCount)
			->description('Registered students.')
			->progress(100*(int)$studentCount/150)
			->hint(150-$studentCount.' more until next milestone.'),
	]);

@endphp

@section('content')
@endsection