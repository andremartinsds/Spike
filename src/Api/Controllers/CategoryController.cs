using Business.Models;
using Data.Test;
using Microsoft.AspNetCore.Mvc;

namespace Api.Controllers;
[ApiController]
[Route("categories")]
public class CategoryController: ControllerBase
{

    [HttpGet()]
    public IEnumerable<Category> GetCategories()
    {
        return BuilderCategory.ListCategories().ToList();
    }
}