    <template>
  <div class="container">
    <header-image/>
    <!-- <slider/> -->
    <div class="row">
      <div class="col-md-12 ml-auto mr-auto">
        <h2 class="title text-center mt-4">Latest Blogposts</h2>

        <br>

        <div v-for="post in posts.data" :key="post.id" class="row justify-content-center">
          <div class="col-lg-12 mt-4">
            <!-- <div class="card card-plain card-blog">
              <div class="card-image">
                <a href="#">
                  <img class="img img-raised rounded" src>
                </a>
              </div>

              <div class="card-body">
                <h6 class="category text-info">Enterprise</h6>
                <h5 class="card-title">
                  <router-link :to="`blog/post/${post.id}`">{{ post.title }}</router-link>
                </h5>
                <p class="card-description">
                  {{ post.body | upperCase }}
                    <router-link :to="`blog/post/${post.id}`" class="d-block text-right">Read More</router-link>

                </p>
              </div>
            </div> -->
                  <div class="card col-md-12 p-3">
                    <div class="row ">
                      <div class="col-md-4">
                        <img class="w-100" src="https://via.placeholder.com/350x350">
                      </div>
                      <div class="col-md-8">
                        <div class="card-block">
                          <h6 class="card-title mt-4"><router-link :to="`blog/post/${post.id}`">{{ post.title }}</router-link></h6>
                          <p class="card-text text-justify">{{ post.body | upperCase }}</p>
                          <!-- <a href="https://www.google.com" class="btn btn-primary">read more...</a> -->
                          <router-link :to="`blog/post/${post.id}`" class="d-block">Read More</router-link>
                        </div>
                      </div>
                    </div>
                  </div>


          </div>
        </div>
                  <pagination class=" mt-5 justify-content-center" :data="posts" @pagination-change-page="getResults">
                      	<span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                  </pagination>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editMode: true,
      posts: {},
      form: new Form({
        id: "",
        title: "",
        body: "",
        photo: ""
      })
    };
  },
  methods: {
    getResults(page = 1) {
      axios.get("post?page=" + page).then(response => {
        this.posts = response.data.posts;
      });
    },
    loadPosts() {
        axios
          .get("post")
          .then(({ data }) => (this.posts = data.posts))
          .catch(() => {});
      }
  },
  created() {
    this.loadPosts();
  }
};
</script>
