<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Posts Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newPostModal" >Add New <i class="fas fa-file fa-fw"></i> </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                      <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Photo</th> 
                        <th>Created at</th>
                        <th>Modify</th>
                    </tr>

                  <tr v-for="post in posts.data" :key="post.id">
                    <td>{{ post.id }}</td>
                    <td>{{ post.title }}</td>
                    <td>{{ post.body | upperCase | truncate(20) }}</td>
                    <!-- <img v-bind="getImgUrl(post.photo)" class="img-thumbnail" width="50" height="auto" alt="Cinque Terre"> -->
                    <td>{{ post.photo }}</td>
                    <td>{{ post.created_at | myDate }}</td>
                    <td>
                        <a href="#" @click="editPostModal(post)">
                            <i class="fa fa-edit blue"></i>
                        </a> 
                   /
                       <a href="#" @click="deletePost(post.id)">
                            <i class="fa fa-trash red"></i>
                        </a> 
                    </td>
                  </tr>
    
                </tbody></table>
              </div>
              <!-- /.card-body -->
                <div class="card-footer">
                  <pagination class=" mt-5 justify-content-center" :data="posts" @pagination-change-page="getResults">
                      	<span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                  </pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNewPostCenter" tabindex="-1" role="dialog" aria-labelledby="addNewPostCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show="!editMode" class="modal-title" id="addNewPostCenterTitle">Add New Post</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewPostCenterTitle">Update Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode ? updatePost() : createPost()">

            
            <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.title" type="text" name="title" placeholder="Title"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                        <has-error :form="form" field="title"></has-error>
                    </div>
              
                    <div class="form-group">
                        <textarea rows="10" cols="50" v-model="form.body" name="body" placeholder="Body"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('body') }"></textarea>
                        <has-error :form="form" field="body"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="photo" class="col-sm-2 control-label">Photo</label>
                        <div class="col-sm-12">
                            <input type="file" @change="updatePhoto" name="photo" class="form-input">
                        </div>
                      </div>
                    <!-- <div class="form-group">
                        <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">Standard User</option>
                            <option value="author">Author</option>
                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div> -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
            </div>
            </form>
            </div>
        </div>
        </div>


    </div>
</template>

<script>
    export default {
        data(){
            return{
               editMode : true,
               posts: {},
               form: new Form({
                    id: '',
                    title: '',
                    body: '',
                    photo: ''
                }),
                // thumbnail: null
                // thumbnail: ''
            }
        
        },
        methods:{
                getResults(page = 1) {
                    axios.get('post?page=' + page)
                        .then(response => {
                            this.posts = response.data.posts;
                    });
                },
                getImgUrl(pic) {
                    // let images = require.context('./images/', false, /\.jpg$/)
                    // return images('./' + pic)
                    return require('./images/'+pic)
                },
               loadPosts(){
                if(this.$gate.isAdmin() || this.$gate.isAuthor()){
                    axios.get('post')
                    .then(({data}) => (this.posts = data.posts))
                    .catch(()=>{
                        console.log("no posts found!!!");
                    });
                }
                },
                newPostModal(){ 
                this.editMode = false;
                this.form.reset();
                 $('#addNewPostCenter').modal('show');
                },
               editPostModal(post){
                    this.editMode = true;
                    this.form.fill(post);
                    $('#addNewPostCenter').modal('show');
                },
               updatePost(){
                this.$Progress.start();
                this.form.put('post/'+this.form.id)
                .then(() => {
                    swal(
                        'Updated!',
                        'the Post has been updated.',
                        'success'
                        )
                    Fire.$emit('PostChange');
                    $('#addNewPostCenter').modal('hide');
                    this.$Progress.finish();
                })
                .catch()
                    this.$Progress.fail();
            },
            updatePhoto(e){
              console.log('uploading');
                let file = e.target.files[0];
                let reader = new FileReader();
                console.log(file);
                
                if (file['size'] < 3000000) {
                  
                  reader.onloadend = (file) => {
                    console.log('RESULT', reader.result)
                    this.form.photo = reader.result;
                  }
                    reader.readAsDataURL(file);
                } else {
                  swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You are uploading a large file!',
                  })
                }

            },
               createPost(){
                this.$Progress.start();
                this.form.post('post').then(()=>{

                    Fire.$emit('PostChange');
                    this.$Progress.finish();
                    $('#addNewPostCenter').modal('hide');

                    toast({
                        type: 'success',
                        title: 'Post created successfully'
                    })

                    }).catch(()=>{

                    });
                },
            deletePost(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.form.delete('post/'+id).then(()=>{
                                        swal(
                                        'Deleted!',
                                        'The post has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('PostChange');
                                }).catch(()=> {
                                    swal("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            }
        },
        created() {
            Fire.$on('PostChange', () => {this.loadPosts()});
            this.loadPosts();
        }
    }
</script>
