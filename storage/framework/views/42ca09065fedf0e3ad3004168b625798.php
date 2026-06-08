<a href="<?php echo e(route('courses.show', $course->slug)); ?>"
   class="course-card"
   style="display:block; text-decoration:none;">

    
    <div class="course-card__thumb" style="position:relative; aspect-ratio:16/9; overflow:hidden; border-radius:12px 12px 0 0; background:#1a1a2e;">

        
        <?php if($course->thumbnail_url): ?>
            <img src="<?php echo e($course->thumbnail_url); ?>"
                 alt="<?php echo e($course->title); ?>"
                 style="width:100%;height:100%;object-fit:cover;display:block;">
        <?php else: ?>
            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1e3a5f,#2d4d7a);display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-graduation-cap" style="font-size:40px;color:rgba(255,255,255,0.3);"></i>
            </div>
        <?php endif; ?>

        
        

        
        <?php if(auth()->guard()->check()): ?>
            <?php
                $isWishlisted = auth()->check() && auth()->user()
                    ->wishlists()->where('course_id', $course->id)->exists();
            ?>
            <button class="course-wishlist <?php echo e($isWishlisted ? 'active' : ''); ?>"
                onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist(this, <?php echo e($course->id); ?>);"
                title="<?php echo e($isWishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist'); ?>"
                aria-label="<?php echo e($isWishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist'); ?>"
                style="position:absolute; top:10px; right:10px; width:34px; height:34px; border-radius:50%; background:rgba(255,255,255,0.9); border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:15px; z-index:2; transition:all 0.2s; color: <?php echo e($isWishlisted ? 'white' : 'var(--text)'); ?>; <?php echo e($isWishlisted ? 'background:#FF6B8A;' : ''); ?>">
                <i class="<?php echo e($isWishlisted ? 'fa-solid' : 'fa-regular'); ?> fa-heart"></i>
            </button>
        <?php endif; ?>

        
        <?php
            $logoUrl = $course->institution->logo_url
                ?? $course->scrapedInstructors->first()?->institution_logo_url
                ?? null;
        ?>
        <?php if($logoUrl): ?>
            <div style="position:absolute;bottom:10px;left:10px;background:white;border-radius:6px;padding:4px 8px;max-width:100px;max-height:40px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.25);z-index:2;">
                <img src="<?php echo e($logoUrl); ?>"
                     alt="<?php echo e($course->institution->name ?? ''); ?>"
                     style="max-width:88px;max-height:32px;object-fit:contain;display:block;"
                     onerror="this.closest('div').style.display='none';">
            </div>
        <?php endif; ?>
    </div>

    
    <div class="course-card__body" style="padding:14px 16px 16px;">

        
        <?php if($course->category): ?>
            <p style="font-size:10px;font-weight:700;letter-spacing:0.09em;text-transform:uppercase;color:var(--purple, #6366f1);margin:0 0 6px;">
                <?php echo e($course->category->name); ?>

            </p>
        <?php endif; ?>

        
        <h3 style="font-size:15px;font-weight:700;line-height:1.4;margin:0 0 6px;color:var(--text);
                   display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
            <?php echo e($course->title); ?>

        </h3>

        
        <?php
            $instructor = $course->scrapedInstructors->first() ?? $course->instructors->first();
        ?>
        <?php if($instructor): ?>
            <p style="font-size:12px;color:var(--muted);margin:0 0 10px;
                      white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                <?php echo e($instructor->name); ?>

                <?php if($instructor->title ?? false): ?>
                    · <span><?php echo e($instructor->title); ?></span>
                <?php endif; ?>
            </p>
        <?php endif; ?>

        
        <div style="display:flex;align-items:center;gap:10px;font-size:12px;color:var(--muted);flex-wrap:wrap;">
            <?php if($course->reviews_avg_rating ?? false): ?>
                <span>
                    <i class="fa-solid fa-star" style="color:#f59e0b;font-size:11px;"></i>
                    <?php echo e(number_format($course->reviews_avg_rating, 1)); ?>

                </span>
            <?php endif; ?>
            <?php if(($course->enrollments_count ?? 0) > 0): ?>
                <span>
                    <i class="fa-solid fa-users" style="font-size:11px;"></i>
                    <?php echo e($course->enrollments_count >= 1000 ? number_format($course->enrollments_count / 1000, 1).'k' : $course->enrollments_count); ?>

                </span>
            <?php endif; ?>
            <?php if($course->duration_weeks): ?>
                <span>
                    <i class="fa-regular fa-clock" style="font-size:11px;"></i>
                    <?php echo e($course->duration_weeks); ?>w
                </span>
            <?php endif; ?>
            <?php if($course->difficulty): ?>
                <span style="text-transform:capitalize;"><?php echo e($course->difficulty); ?></span>
            <?php endif; ?>
        </div>

    </div>
</a>
<?php /**PATH C:\laragon\www\coursify\resources\views/components/course-card.blade.php ENDPATH**/ ?>