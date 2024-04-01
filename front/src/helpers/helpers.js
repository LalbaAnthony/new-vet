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

// need to improve this function
export async function imageExists(url) {
    new Promise((resolve) => {
        var img = new Image();
        img.onload = function () {
            resolve(true);
        };
        img.onerror = function () {
            resolve(false);
        };

        img.src = url;
    }
    ).then(exists => {
        if (exists) return true;
        return false;
    });
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

export function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

export function roundNb(nb, precision = 2) {
    return nb.toFixed(precision);
}

export function hello() {
    const hour = new Date().getHours();
    return hour >= 6 && hour < 18 ? 'Bonjour' : 'Bonsoir';
}

export function missingElementsPassword(password) {
    let missing_element = [];
    if (password.length <= 10) missing_element.push('10 caractères');
    if (!password.match(/[a-z]/)) missing_element.push('1 minuscule');
    if (!password.match(/[A-Z]/)) missing_element.push('1 majuscule');
    if (!password.match(/[0-9]/)) missing_element.push('1 chiffre');
    if (!password.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/)) missing_element.push('1 caractère spécial');

    return missing_element;
}
