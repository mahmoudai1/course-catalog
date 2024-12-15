class APIClient {
  constructor(baseURL) {
      this.baseURL = baseURL;
  }

  async get(endpoint) {
      try {
          const response = await fetch(`${this.baseURL}${endpoint}`);
          if (!response.ok) {
              throw new Error(`Error: ${response.statusText}`);
          }
          const data = await response.json();
          return data;
      } catch (error) {
          console.error(error);
          return { error: error.message }; 
      }
  }

  async post(endpoint, body) {
      try {
          const response = await fetch(`${this.baseURL}${endpoint}`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify(body),
          });
          if (!response.ok) {
              throw new Error(`Error: ${response.statusText}`);
          }
          const data = await response.json();
          return data;
      } catch (error) {
          console.error(error);
          return { error: error.message };
      }
  }
}

class CategoryAPIs extends APIClient {
  constructor(baseURL) {
      super(baseURL);
  }

  async getCategoriesTreeAPI() {
    let data = sessionStorage.getItem("categories-tree");
    if(data){
        return await JSON.parse(data);
    }

    return await this.get(`/api.php/v1/getCategoriesTree`);
  }
}

class CourseAPIs extends APIClient {
    constructor(baseURL) {
        super(baseURL);
    }
  
    async getCoursesAPI() {
        let data = sessionStorage.getItem("courses");
        if(data){
            return await JSON.parse(data);
        }

        return await this.get(`/api.php/v1/getCourses`);
    }

    async getCoursesByCategoryIdAPI(categoryId) {
        let data = sessionStorage.getItem("courses-by-category-" + categoryId);
        if(data){
            return await JSON.parse(data);
        }

        return await this.get(`/api.php/v1/getCoursesByCategoryId?id=` + categoryId);
    }
  }

document.addEventListener('DOMContentLoaded', function() {
    const baseURL = 'http://api.cc.localhost';

    const categoryAPIs = new CategoryAPIs(baseURL);
    const courseAPIs = new CourseAPIs(baseURL);

    categoryAPIs.getCategoriesTreeAPI().then((response) => {
        if(response.code === 200){
            setSessionStorage("categories-tree", response);
            updateCategories(response.data);
        } else {
            updateCategories([]);
        }
    }).catch((error) => {
        console.error('Error fetching data:', error);
    });


    courseAPIs.getCoursesAPI().then((response) => {
        if(response.code === 200){
            setSessionStorage("courses", response);
            updateCourses(response.data);
        } else {
            updateCourses([]);
        }
    }).catch((error) => {
        console.error('Error fetching data:', error);
    });
});

function getCoursesByCategoryIdClicked(categoryId){
    const baseURL = 'http://api.cc.localhost';
    const courseAPIs = new CourseAPIs(baseURL);

    let selectedCategory = localStorage.getItem("selectedCategory");

    // prevent selecting the same category and make duplicate useless calls
    if(selectedCategory !== categoryId){
        courseAPIs.getCoursesByCategoryIdAPI(categoryId).then((response) => {
            if(response.code === 200){
                setSessionStorage("courses-by-category-" + categoryId, response);
                updateCourses(response.data, categoryId);
            } else {
                updateCourses([]);
            }
        }).catch((error) => {
            console.error('Error fetching data:', error);
        });
    }
}

function setSessionStorage(key, responseData){
    let data = sessionStorage.getItem(key);
    if(!data){
        sessionStorage.setItem(key, JSON.stringify(responseData));
    }
}