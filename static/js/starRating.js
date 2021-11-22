const displayRating = (rating, restaurant_id) => {
    rating = parseFloat(rating);
    const pct = (rating/5)*100;
    const roundedRating = `${!isNaN(Math.round(pct / 10) * 10) ? Math.round(pct / 10) * 10 : 0}%`;
    document.querySelector(`.rest-${restaurant_id} .stars-inner`).style.width = roundedRating;
}