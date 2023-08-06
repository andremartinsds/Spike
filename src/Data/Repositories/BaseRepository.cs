using Business.Interfaces;
using Business.Models;
using Data.Context;
using Microsoft.EntityFrameworkCore;

namespace Data.Repositories;

public abstract class BaseRepository<T> : IBaseRepository<T> where T : Entity
{
    protected readonly DataDbContext DbContext;
    protected readonly DbSet<T> DbSet;

    public BaseRepository(DataDbContext dataDbContext)
    {
        DbContext = dataDbContext;
        DbSet = DbContext.Set<T>();
    }
    
    public async Task Add(T entity)
    {
        DbSet.Add(entity);
        await SaveChanges();
    }

    public async Task<T> FindById(Guid id)
    {
        return await DbSet.FindAsync(id);
    }

    public async Task<List<T>> FindMany()
    {
        return await DbSet.ToListAsync();
    }
    
    public async Task<List<T>> FindWithPagination(int skip, int take = 10)
    {
        return await DbSet.Skip(skip).Take(take).ToListAsync();
    }

    public async Task Update(T entity)
    {
        DbSet.Update(entity);
        await SaveChanges();
    }

    public async Task Remove(T entity)
    {
        DbSet.Remove(entity);
        await SaveChanges();
    }

    public void Dispose()
    {
        DbContext.Dispose();
    }

    public async Task<int> SaveChanges()
    {
        return await DbContext.SaveChangesAsync();
    }
}