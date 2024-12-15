<?php

namespace database\migrations;

class InsertIntoCoursesTable
{
  function up() {
    return "
        INSERT INTO courses (id, name, description, preview, category_id, created_at, updated_at) VALUES
        ('L373349028', 'Diversity and Inclusion for a Better Business', 'Diversity can seem like a difficult concept to incorporate into the culture of a business. Leaders often view diversity initiatives as important but see them as secondary to the day-to-day operations of a successful business. You may ask yourself, where and how do I start? In this course, we’ll look at many strategies that can help jumpstart diversity and inclusion initiatives. Through these initiatives, we can build stronger relationships that improve the overall business environment and how it functions. These relationships can drive stability, sustainability, and profitability for years to come.', 'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373349028/800--v112240.jpg', '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f8a', NOW(), NOW()),
        ('L373371072', 'Leadership for Identity Diversity', 'As a leader, people of many different backgrounds will look to you for guidance and security in the workplace. The individual identities within a workplace can include individuals from different racial and ethnic backgrounds, individuals with different gender and sexual identities, and individuals with different disabilities. One of the goals of a leader is to create a safe and inclusive environment for all employees. When creating an inclusive environment, it’s important to be aware of who you''re creating it for and what their individual needs are. Recognizing individuality and implementing inclusion practices benefit everyone and improve your business’s culture.', 'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373371072/800--v112239.jpg', '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f8a', NOW(), NOW()),
        ('L373324687', 'Applying Yourself to Diverse and Inclusive Leadership', 'Improving diversity in the workplace requires strategic planning and mindful consideration from everyone involved because inclusion in the workplace is a team effort. When a leader is a participant in change rather than a director, the culture is able to transform with them. Strategies such as improved communication, modeling positivity and adaptability, and building relationships can help make the transition smoother. Effectively changing the culture of a business requires commitment and determination, which is why it’s important to know of leadership strategies that you can use to help you build and maintain a sustainable culture of diversity and equity.', 'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373324687/800--v112241.jpg', '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f82', NOW(), NOW()),
        ('L373312762', 'Finance and Accounting Basics for Nonfinancial Executives', 'Financial knowledge is vital to an executive’s role in a business, but the systems within a business can be extremely complex. Without a strong foundation of financial analytics, it can be difficult to interpret, report, or even understand a business’s financial standing. A lack of understanding can impede your ability to make educated decisions. By understanding where the data comes from and how accounting operates, you can manage your business with greater efficiency and interpret business systems more accurately.', 'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373312762/800--v112243.jpg', '4e5f6a7b-8c9d-0e1f-2a3b-4c5d6e7f8a9b', NOW(), NOW()),
        ('L373319845', 'Financial Statements and Reporting for Nonfinancial Executives', 'Financial statements are a critical part of attracting investors. Financial reports like income statements are the hard proof of how your business is doing. Properly interpreting these statements can provide a stronger understanding of your business’s performance. This can also assist your company when acquiring new investments and making strategic business decisions. Your reliable and precise numbers may encourage shareholders and investors to feel more confident when working with you.', 'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373319845/800--v112244.jpg', '5f6a7b8c-9d0e-1f2a-3b4c-5d6e7f8a9b0c', NOW(), NOW()),
        ('L373327593', 'Financial Planning and Analysis for Nonfinancial Executives', 'With constant market fluctuation and an unpredictable supply chain, sometimes it can be difficult to project where your business will be tomorrow. That’s where financial forecasting comes in. The data you have today can be used in various ratios and equations to create helpful financial estimates for your business. You can also use different aspects of financial and managerial accounting to better present your finances to potential and existing stakeholders. Streamlined financial reporting, planning, and analysis techniques can improve your business’s competitive strategy.', 'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373327593/800--v112246.jpg', '7b8c9d0e-1f2a-3b4c-5d6e-7f8a9b0c1d2e', NOW(), NOW()),
        ('L373395597', 'Valuation for Nonfinancial Executives', 'Investments always involve a bit of risk, but you can lower that risk by analyzing your company’s current and future value. There are many options when it comes to funding a business or a project. Funding can be acquired through both debt and equity, as well as working capital. Learning the inner workings of project and relative valuation can help improve your investment decision-making skills and understand which projects will bring the best results.', 'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373395597/800--v112241.jpg', '1f2a3b4c-5d6e-7f8a-9b0c-1d2e3f4a5b6c', NOW(), NOW()),
        ('L373337574', 'Defining Cross-Cultural Leadership', 'The modern business landscape is noticeably globalized. People from many countries and cultures work together, whether in-person or remotely. You might work in an environment like this yourself, or you likely will in the future. That’s why it’s critical for you, as a leader, to have the necessary skills to navigate cultural differences within your company. Otherwise, you might not know how best to leverage your employees’ skills. So how can you do this? How can you become a cross-cultural leader?', 'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373337574/800--v112262.jpg', '8a9b0c1d-2e3f-4a5b-6c7d-8e9f0a1b2c3d', NOW(), NOW());
    ";
  }

  function down() {
    return "
      DELETE FROM courses WHERE ID IN (
        'L373349028',
        'L373371072',
        'L373324687',
        'L373312762',
        'L373319845',
        'L373327593',
        'L373395597',
        'L373337574'
      )
    ";
  }
}