function updateCategories(categories){
  let newRoot = true;

  let categoriesWrapper = document.getElementById('categories-wrapper');
  let categoryWrapper;

  let marginLeft = 0;
  let previousCategoryId = null;

  categories.forEach((category) => {
    if(category.parent_id === null){
      newRoot = true;
    }

    if(category.parent_id == previousCategoryId){
      marginLeft += 1;
    }

    if(newRoot){
      marginLeft = 0;

      if(categoryWrapper){
        categoriesWrapper.appendChild(categoryWrapper);
      }

      categoryWrapper = document.createElement('div');
      categoryWrapper.className = "category-wrapper";
      newRoot = false;
    }

    let selectedCategory = localStorage.getItem("selectedCategory");
    let currentSelectedStatus = selectedCategory == category.category_id ? "selected-" : "";

    if(category.count_of_courses > 0){
      const categoryWithCount = document.createElement('div');
      categoryWithCount.className = "category-with-count";
      categoryWithCount.style.setProperty('margin-left', marginLeft + 'rem', 'important');

      const categoryName = document.createElement('div');
      categoryName.className = currentSelectedStatus + "category-name";
      categoryName.innerHTML = category.category_name;

      const categoryCoursesCount = document.createElement('div');
      categoryCoursesCount.className = currentSelectedStatus + "category-courses-count";
      categoryCoursesCount.innerHTML = category.count_of_courses;

      categoryWithCount.onclick = () => {
        getCoursesByCategoryIdClicked(category.category_id);
        changeSelectedCategory(categoryName, categoryCoursesCount);
      };

      categoryWithCount.appendChild(categoryName);
      categoryWithCount.appendChild(categoryCoursesCount);
      categoryWrapper.appendChild(categoryWithCount);
    } else {
      const normalCategory = document.createElement('div');
      normalCategory.className = "normal-category";
      normalCategory.style.setProperty('margin-left', marginLeft + 'rem', 'important');
      

      const categoryName = document.createElement('div');
      categoryName.className = currentSelectedStatus + "category-name";
      categoryName.innerHTML = category.category_name;

      normalCategory.onclick = () => {
        getCoursesByCategoryIdClicked(category.category_id);
        changeSelectedCategory(categoryName);
      };

      normalCategory.appendChild(categoryName);
      categoryWrapper.appendChild(normalCategory);
    }

    previousCategoryId = category.category_id;
  })
}

function updateCourses(courses, categoryId = null){
  let coursesWrapper = document.getElementById('courses-wrapper');

  if(courses.length > 0){
    coursesWrapper.innerHTML = '';
  
    courses.forEach((course) => {
      const courseDiv = document.createElement('div');
      courseDiv.className = "course";
  
      const courseImgAndMainCategory = document.createElement('div');
      courseImgAndMainCategory.className = "course-img-and-main-category";
  
      const img = document.createElement('img');
      img.src = course.preview;
      img.alt = course.name;
      img.loading = 'lazy';
  
      const courseMainCategory = document.createElement('div');
      courseMainCategory.innerHTML = course.main_category_name;
  
      courseImgAndMainCategory.appendChild(img);
      courseImgAndMainCategory.appendChild(courseMainCategory);
  
  
      const courseInfo = document.createElement('div');
      courseInfo.className = 'course-info';
  
      const courseNameH3 = document.createElement('h3');
      courseNameH3.className = 'course-name';
      courseNameH3.innerHTML = truncateTextForDesktopLayout(course.name);
      courseNameH3.title = course.name;
  
      const courseDescription = document.createElement('p');
      courseDescription.className = 'course-description';
      courseDescription.innerHTML = truncateTextForDesktopLayout(course.description);
      courseDescription.title = course.description;
  
      courseInfo.appendChild(courseNameH3);
      courseInfo.appendChild(courseDescription);
  
      courseDiv.appendChild(courseImgAndMainCategory);
      courseDiv.appendChild(courseInfo);
  
      coursesWrapper.appendChild(courseDiv);
    });
  } else {
    coursesWrapper.innerHTML = 'No courses found for this category.';
    coursesWrapper.style.color = "gray";
  }

  localStorage.setItem("selectedCategory", categoryId);
}

function changeSelectedCategory(categoryNameElement, categoryCountElement = null){
  const selectedCategoryName = document.querySelector('.selected-category-name');
    if (selectedCategoryName) {
        selectedCategoryName.classList.remove('selected-category-name');
        selectedCategoryName.classList.add('category-name');
    }

    const selectedCategoryCount = document.querySelector('.selected-category-courses-count');
    if (selectedCategoryCount) {
        selectedCategoryCount.classList.remove('selected-category-courses-count');
        selectedCategoryCount.classList.add('category-courses-count');
    }
    categoryNameElement.classList.remove('category-name');
    categoryNameElement.classList.add('selected-category-name');

    if (categoryCountElement) {
        categoryCountElement.classList.remove('category-courses-count');
        categoryCountElement.classList.add('selected-category-courses-count');
    }
}

function truncateTextForDesktopLayout(text) {
  const isDesktop = window.innerWidth > 1024;
  if (isDesktop && text.length > 75) {
      return text.substring(0, 75) + '...';
  }

  return text;
}
