export function isMobile() {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true
    } else {
        return false
    }
}

export function threeDotString(str, maxLen = 100) {
    if (str.length <= maxLen) return str;
    return str.slice(0, maxLen).trim() + " ...";
}

export function ageFromDate(birthDate) {
    const [day, month, year] = birthDate.split('/').map(Number);
    const currentDate = new Date();
    const birthday = new Date(year, month - 1, day);
    let age = currentDate.getFullYear() - birthday.getFullYear();
    if (
        currentDate.getMonth() < birthday.getMonth() ||
        (currentDate.getMonth() === birthday.getMonth() &&
            currentDate.getDate() < birthday.getDate())
    ) {
        age--;
    }

    return age;
}

export function imageExists(url) {
    var img = new Image();
    img.src = url;
    return img.height != 0;
    // return true;
}

export function randSearchPlaceholder() {
    const placeholders = [
        'Rechercher ...',
        'Chercher un produit ...',
        'Chercher une catégorie ...',
        'Chercher un article ...',
        'Rechercher un produit ...',
        'Rechercher une catégorie ...',
        'Rechercher un article ...',
        'Trouver un produit ...',
        'Trouver un article ...',
        'Trouver une catégorie ...'
    ];
    return placeholders[Math.floor(Math.random() * placeholders.length)]
}