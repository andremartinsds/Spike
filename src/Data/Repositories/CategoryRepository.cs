using Business.Interfaces;
using Business.Models;
using Data.Context;

namespace Data.Repositories;

public class CategoryRepository : BaseRepository<Category>, ICategoryRepository
{
    public CategoryRepository(DataDbContext dataDbContext) : base(dataDbContext)
    {
    }
}