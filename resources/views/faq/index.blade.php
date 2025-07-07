@extends('layout.app')
@section('title', 'faq')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-12 my-4">
                <h2 class="fw-bold text-primary">FAQ Details</h2>
            </div>

            <div class="col-12">
                <a href="{{route('faq.create')}}" class="btn btn-primary">Create</a>
            </div>

            <div class="col-12 mb-4">
                <input type="text" id="search" class="form-control" placeholder="Search faqs...">
            </div>

            <div class="col-12 mt-4" id="faqTable">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Topic</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Email</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($faqs as $faq)
                      <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$faq->topic}}</td>
                        <td>{{$faq->comment}}</td>
                        <td>{{$faq->email}}</td>
                        <td>
                            <a href="javascript:void(0)" class="text-danger me-3" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            onclick="appendId('{{$faq->id}}')"><i class="bi bi-trash3"></i></a>
                            <a href="{{route('faq.edit',$faq->id)}}" class="text-warning"><i class="bi bi-pencil-square"></i></a>
                        </td>
                      </tr>


                    @endforeach
                    </tbody>
                  </table>
                  {{ $faqs->links() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header border-0">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h2 class="text-center fs-1">Are You Sure?</h2>
            </div>
            <form action="" method="post" id="deleteForm">
                @csrf
                @method('DELETE')
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              <button type="submit" class="btn btn-primary">Delete</button>
            </div>
            </form>
          </div>
        </div>
      </div>

@endsection

@section('js')
      <script>
        const appendId = (X) => {
        document.getElementById('deleteForm').action = "{{route('faq.destroy', ':id')}}".replace(':id', X);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search");

        searchInput.addEventListener("input", function () {
            let query = this.value;

            fetch(`?search=${query}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTbody = doc.querySelector("#faqTable tbody");
                const newPagination = doc.querySelector(".pagination");

                if (newTbody) {
                    document.querySelector("#faqTable tbody").innerHTML = newTbody.innerHTML;

                    // Optional: Replace pagination if included
                    if (newPagination) {
                        document.querySelector(".pagination").innerHTML = newPagination.innerHTML;
                    }
                }
            })
            .catch(error => console.error('Search error:', error));
        });
    });
      </script>
@endsection
