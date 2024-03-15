<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <h3>Blog</h3>
                <hr />
                <div class="admin-blog w-50">
                    <div>
                        <label>Blog Title</label>
                        <input id="blog_title" placeholder="" class="form-control" type="text" />
                        <br />
                        <label>Blog Category</label>
                        <input id="blog_category" placeholder="" class="form-control" type="text" />
                        <br />
                        <label>Blog Content</label>
                        <textarea id="blog_content" placeholder="" class="form-control" type="text"></textarea>
                        <br />
                        <div class="d-none">
                            <img id="blog_img" src="" alt="">
                        </div>
                        <br />
                        <div class="">
                            <label>Blog Image</label>
                            <button class="btn btn-outline-success">Upload</button>
                        </div>
                        <br />
                        <button class="btn w-25 bg-gradient-primary" onclick="saveBlogsInfo()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function saveBlogsInfo() {
        const payload = {
            blogs_title: document.getElementById('blog_title').value,
            blogs_category: document.getElementById('blog_category').value,
            blogs_content: document.getElementById('blog_content').value,
            // blog_img: document.getElementById('blog_img'),
        }

        const res = await axios.post('/admin/saveBlogData', payload, HeaderToken());

        if (res.status === 200 && res.data['status'] === 'success') {
            successToast(res.data['message']);
        } else {
            errorToast(res.data['message']);
        }

    }
</script>
