<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdmin() || $gate.isAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">posts Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newPostModal" >Add New <i class="fas fa-post-plus fa-fw"></i> </button>
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
                        <th>Registered at</th>
                        <th v-if="$gate.isAdmin()">Modify</th>
                    </tr>

                  <tr v-for="post in posts.data" :key="post.id">
                    <td>{{ post.id }}</td>
                    <td>{{ post.title }}</td>
                    <td>{{ post.body | upperCase }}</td>
                    <td>{{ post.created_at | myDate }}</td>
                    <td v-if="$gate.isAdmin()">
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
        <div class="not-found" v-if="!$gate.isAdmin() && !$gate.isAuthor()">
           <not-found /> 
        </div>  
        <!-- Modal -->
        <div class="modal fade" id="addNewPostCenter" tabindex="-1" role="dialog" aria-labelledby="addNewPostCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show="!editMode" class="modal-title" id="addNewPostCenterTitle">Add New post</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewPostCenterTitle">Update post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode ? updatePost() : createPost()">

            
            <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name" placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.email" type="text" name="email" placeholder="Email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.bio" type="text" name="bio" placeholder="Bio"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                        <has-error :form="form" field="bio"></has-error>
                    </div>

                    <div class="form-group">
                        <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">Select post Role</option>
                            <option value="admin">Admin</option>
                            <option value="post">Standard post</option>
                            <option value="author">Author</option>
                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>

                       <div class="form-group">
                        <input v-model="form.password" type="password" name="password" placeholder="Password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>

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
                    body: ''
                })
            }
        },
        methods:{
            getResults(page = 1) {
			axios.get('post?page=' + page)
				.then(response => {
					this.posts = response.data;
				});
		    },
            updatePost(){
                this.$Progress.start();
                this.form.put('post/'+this.form.id)
                .then(() => {
                    swal(
                        'Updated!',
                        'the post info has been updated.',
                        'success'
                        )
                    Fire.$emit('postChange');
                    $('#addNewPostCenter').modal('hide');
                    this.$Progress.finish();
                })
                .catch()
                    this.$Progress.fail();
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
            loadPosts(){
                if(this.$gate.isAdmin() || this.$gate.isAuthor()){
                    axios.get('post').then(({data}) => (this.posts = data))
                }
            },
            createPost(){
                this.$Progress.start();
                this.form.post('post').then(()=>{

                    Fire.$emit('postChange');
                    this.$Progress.finish();
                    $('#addNewPostCenter').modal('hide');

                    toast({
                        type: 'success',
                        title: 'post created successfully'
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
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('postChange');
                                }).catch(()=> {
                                    swal("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            },

        },
        created() {
            Fire.$on('searching', () => {
                let q = this.$parent.search;
                axios.get('findPost?q='+ q)
                .then( data => {
                    this.posts = data.data;
                }).catch(() => {

                })
            });
            this.loadPosts();
            Fire.$on('postChange', () => {this.loadPosts()});
        }
    }
</script>
