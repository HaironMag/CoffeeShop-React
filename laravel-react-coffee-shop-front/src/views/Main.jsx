import { useEffect, useState } from "react";
import axiosClient from "../axios-client";

export default function Main() {
    const [coffee, setCoffee] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    const getCoffee = () => {
        setLoading(true);
        setError(null);
        axiosClient.get('/coffees')
            .then(({ data }) => {
                setLoading(false);
                console.log('Получены данные кофе:', data);
                
                if (data && Array.isArray(data.data)) {
                    const coffeeWithIds = data.data.map((item, index) => ({
                        ...item,
                        id: `coffee-${index}-${item.name?.replace(/\s+/g, '-') || 'item'}`
                    }));
                    setCoffee(coffeeWithIds);
                } else {
                    setCoffee([]);
                    console.warn('Некорректный формат данных:', data);
                }
            })
            .catch((error) => {
                setLoading(false);
                setError('Ошибка загрузки меню');
                console.error('Ошибка загрузки кофе:', error);
            })
    }

    useEffect(() => {
        getCoffee();
    }, [])

    return (
        <div className="coffee-menu-container">
            <div className="menu-header">
                <h1>Наше Меню</h1>
                <p className="menu-subtitle">Выберите свой идеальный кофе</p>
            </div>

            {error && (
                <div className="error-message" style={{
                    background: '#fee',
                    color: '#c00',
                    padding: '1rem',
                    borderRadius: '8px',
                    marginBottom: '1rem',
                    textAlign: 'center'
                }}>
                    {error}
                </div>
            )}

            {loading && (
                <div className="loading-container">
                    <div className="loading-spinner"></div>
                    <p>Загрузка меню...</p>
                </div>
            )}

            {!loading && !error && coffee.length > 0 && (
                <div className="coffee-grid">
                    {coffee.map(c => (
                        <div key={c.id} className="coffee-card">
                            <div className="coffee-card-image">
                                {c.image ? (
                                    <img
                                        src={c.image.startsWith('data:image') 
                                            ? c.image 
                                            : c.image.startsWith('http')
                                                ? c.image
                                                : `${import.meta.env.VITE_BASE_URL_APP}${c.image.startsWith('/') ? '' : '/'}${c.image}`
                                        }
                                        alt={c.name || 'Кофе'}
                                        onError={(e) => {
                                            console.error('Error loading image:', c.image);
                                            e.target.style.display = 'none';
                                            e.target.parentElement.innerHTML = 
                                                '<div class="image-placeholder" style="width:100%;height:200px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;border-radius:8px;">' +
                                                '<span style="font-size:48px;">☕</span>' +
                                                '</div>';
                                        }}
                                    />
                                ) : (
                                    <div className="image-placeholder">
                                        <span>☕</span>
                                    </div>
                                )}
                            </div>

                            <div className="coffee-card-content">
                                <h3 className="coffee-name">{c.name || 'Без названия'}</h3>
                                <p className="coffee-description">{c.description || 'Описание отсутствует'}</p>

                                <div className="coffee-details">
                                    {c.size && c.size.name && (
                                        <div className="coffee-size">
                                            <span className="detail-icon">📏</span>
                                            <span>
                                                {c.size.name} 
                                                {c.size.ml && ` (${c.size.ml} мл)`}
                                                {!c.size.ml && ` (размер)`}
                                            </span>
                                        </div>
                                    )}

                                    <div className="coffee-price">
                                        {c.price ? (
                                            <>
                                                <span className="price-value">{c.price}</span>
                                                <span className="price-currency"> ₽</span>
                                            </>
                                        ) : (
                                            <span className="price-placeholder">Цена уточняется</span>
                                        )}
                                    </div>
                                </div>

                                <button className="btn-add-to-cart" disabled={!c.available}>
                                    {c.available ? 'Добавить в корзину' : 'Недоступно'}
                                </button>
                            </div>
                        </div>
                    ))}
                </div>
            )}

            {!loading && !error && coffee.length === 0 && (
                <div className="empty-menu">
                    <p>Меню пока пусто. Скоро здесь появятся вкусные напитки!</p>
                </div>
            )}
        </div>
    )
}