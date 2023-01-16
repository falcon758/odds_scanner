SELECT 
    employees.FIRST_NAME,
    employees.LAST_NAME,
    jobs.JOB_TITLE,
    departments.DEPARTMENT_ID
FROM employees
INNER JOIN jobs ON employees.JOB_ID = jobs.JOB_ID
INNER JOIN departments ON employees.DEPARTMENT_ID = departments.DEPARTMENT_ID
INNER JOIN locations ON departments.LOCATION_ID = locations.LOCATION_ID
WHERE locations.city = 'London'