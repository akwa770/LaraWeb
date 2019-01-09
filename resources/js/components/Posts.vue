<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Posts Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newPost" >Add New <i class="fas fa-file fa-fw"></i> </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                      <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Author</th>
                        <th>Created at</th>
                        <th>Modify</th>
                    </tr>

                  <tr v-for="user in users" :key="user.id">
                    <td>{{ post.id }}</td>
                    <td>{{ post.title }}</td>
                    <td>{{ post.description | upperCase }}</td>
                    <td>{{ post.author }}</td>
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
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNewPostCenter" tabindex="-1" role="dialog" aria-labelledby="addNewPostCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show="!editMode" class="modal-title" id="addNewUserCenterTitle">Add New Post</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewUserCenterTitle">Update Post</h5>
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
                        <textarea v-model="form.description" name="description" placeholder="Description"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                        <has-error :form="form" field="description"></has-error>
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
               users: {},
               form: new Form({
                    id: '',
                    title: '',
                    description: '',
                    author: '',
                    photo: ''
                })
            }
        
        }
    }
</script>
