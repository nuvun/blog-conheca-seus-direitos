<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsletterRequest;
use App\Http\Requests\UpdateNewsletterRequest;
use App\Http\Resources\Admin\NewsletterResource;
use App\Models\Newsletter;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsletterApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('newsletter_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsletterResource(Newsletter::all());
    }

    public function store(StoreNewsletterRequest $request)
    {
        $newsletter = Newsletter::create($request->all());

        return (new NewsletterResource($newsletter))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Newsletter $newsletter)
    {
        abort_if(Gate::denies('newsletter_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsletterResource($newsletter);
    }

    public function update(UpdateNewsletterRequest $request, Newsletter $newsletter)
    {
        $newsletter->update($request->all());

        return (new NewsletterResource($newsletter))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Newsletter $newsletter)
    {
        abort_if(Gate::denies('newsletter_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $newsletter->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
