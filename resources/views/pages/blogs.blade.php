@extends('layout.app')

@section('content')
    <div class="banner">
        <div class="banner-overlay">
            <img src="https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Banner Image">
        </div>
        <div class="banner-text">
            <h1 class="blog-banner-text text-capitalize">Blogs</h1>
        </div>
    </div>

    <div id="blogs"></div>

    <script>
        const blogBannerText = document.querySelector('.blog-banner-text');

        async function getBlogPageInfo() {
            const res = await axios.get('/blogs/getBlogsPageInfo');
            blogBannerText.textContent = res.data['data'][0].blogs_page_title
        }

        async function getBlogs() {
            const blogsDiv = document.getElementById('blogs');
            const res = await axios.get('/blogs/getAllBlogs', HeaderToken());
            const blogs = res.data['data']

            let html = ''

            blogs.forEach(blog => {
                html += `<div class="row m-5 p-5 w-90">
            <div class="col-md-4">
                <img class="blog-image" style="max-width: 100%"
                    src="https://img.freepik.com/free-photo/ai-technology-microchip-background-digital-transformation-concept_53876-124669.jpg?t=st=1709131730~exp=1709135330~hmac=2743fb1c835e5b84bb0ca50de5753e8a297ce79a9228f6f3e723cb755df8c83e&w=1380"
                    alt="">
            </div>
            <div class="col-md-8">
                <h3 class="blog-title">${blog.blogs_title}</h3>
                <p class="blog-content">${blog.blogs_content}</p>
                <button class="btn bg-info text-white">Read More</button>
            </div>
        </div>`
            })

            blogsDiv.innerHTML = html


        }

        getBlogs()
        getBlogPageInfo()
    </script>
@endsection
