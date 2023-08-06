using Business.Models;

namespace Business.Interfaces;

public interface IBaseRepository<T> : IDisposable where T : Entity
{
    Task Add(T entity);
    //TODO: add others contracts
}