<div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 position-relative">
                <h5 class="m-0 font-weight-bold">
                    <i class="far fa-newspaper"></i> Editorias/Colunas
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead class="text-center">
                    <tr>
                        <th scope="col"><i class="fas fa-trophy"></i></th>
                        <th scope="col" class="text-left"><i class="fas fa-user"></i></th>
                        <th scope="col"><i class="far fa-newspaper"></i></th>
                        <th scope="col"><i class="far fa-eye"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($postsCategories as $postCategory)
                        <tr class="text-center">
                            <th scope="row" class="align-middle">{{ $loop->iteration }}º</th>
                            <td class="text-left d-flex align-items-center">
                                {{ $postCategory->category_name }}
                            </td>
                            <td class="align-middle">{{ $postCategory->total_posts }}</td>
                            <td class="align-middle">{{ $postCategory->total_views }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
