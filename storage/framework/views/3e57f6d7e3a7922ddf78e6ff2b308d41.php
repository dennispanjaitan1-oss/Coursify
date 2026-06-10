<?php $__env->startSection('title', 'Course Builder — ' . $course->title); ?>

<?php $__env->startSection('content'); ?>
<style>
:root {
    --cb-purple: #7B6FE8; --cb-purple-dark: #5B4FD8; --cb-teal: #00C896;
    --cb-gold: #F59E0B; --cb-red: #EF4444; --cb-bg: #F8F7FF;
    --cb-card: #FFFFFF; --cb-border: #E8E4F8; --cb-text: #1A1825;
    --cb-muted: #9B94C1; --cb-soft: #6B6490;
}
.cb-header { background: linear-gradient(135deg, #1A1825 0%, #2D2550 100%); padding: 28px 32px; color: white; border-radius: 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
.cb-header h1 { font-size: 22px; font-weight: 700; margin: 0; }
.cb-header p { font-size: 13px; opacity: 0.7; margin: 4px 0 0; }
.cb-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: 0.05em; }
.badge-draft { background: rgba(245,158,11,0.2); color: #F59E0B; }
.badge-published { background: rgba(0,200,150,0.2); color: #00C896; }

.cb-tabs { display: flex; gap: 4px; background: white; border: 1px solid var(--cb-border); border-radius: 12px; padding: 4px; margin-bottom: 24px; flex-wrap: wrap; }
.cb-tab { padding: 9px 18px; border-radius: 9px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; background: transparent; color: var(--cb-muted); transition: all .2s; display: flex; align-items: center; gap: 6px; }
.cb-tab.active { background: var(--cb-purple); color: white; box-shadow: 0 4px 12px rgba(123,111,232,.3); }
.cb-tab:hover:not(.active) { background: var(--cb-bg); color: var(--cb-text); }

.cb-panel { display: none; }
.cb-panel.active { display: block; }

.cb-card { background: white; border: 1px solid var(--cb-border); border-radius: 14px; margin-bottom: 16px; overflow: hidden; }
.cb-card-head { padding: 16px 20px; border-bottom: 1px solid var(--cb-border); display: flex; align-items: center; justify-content: space-between; }
.cb-card-title { font-size: 14px; font-weight: 700; color: var(--cb-text); display: flex; align-items: center; gap: 8px; }
.cb-card-body { padding: 20px; }

.form-label { display: block; font-size: 12px; font-weight: 700; color: var(--cb-soft); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; }
.form-control { width: 100%; padding: 10px 14px; border: 1.5px solid var(--cb-border); border-radius: 10px; font-size: 14px; color: var(--cb-text); background: #FAFAFA; transition: border-color .2s; font-family: inherit; box-sizing: border-box; }
.form-control:focus { outline: none; border-color: var(--cb-purple); background: white; box-shadow: 0 0 0 3px rgba(123,111,232,.1); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
.form-group { margin-bottom: 16px; }
.form-group:last-child { margin-bottom: 0; }

.btn-primary { display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px; background: linear-gradient(135deg, var(--cb-purple), var(--cb-purple-dark)); color: white; border: none; border-radius: 999px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all .2s; text-decoration: none; }
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(123,111,232,.35); }
.btn-outline { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; background: white; color: var(--cb-soft); border: 1.5px solid var(--cb-border); border-radius: 999px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; text-decoration: none; }
.btn-outline:hover { border-color: var(--cb-purple); color: var(--cb-purple); }
.btn-danger-sm { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #FFF0F0; color: var(--cb-red); border: 1px solid #FECACA; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all .2s; border: none; }
.btn-danger-sm:hover { background: var(--cb-red); color: white; }
.btn-teal-sm { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: rgba(0,200,150,.1); color: var(--cb-teal); border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all .2s; border: none; }
.btn-teal-sm:hover { background: var(--cb-teal); color: white; }
.btn-ghost-sm { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: var(--cb-bg); color: var(--cb-soft); border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all .2s; border: none; }
.btn-ghost-sm:hover { background: var(--cb-border); color: var(--cb-text); }

/* Curriculum */
.section-block { border: 1.5px solid var(--cb-border); border-radius: 12px; margin-bottom: 14px; overflow: hidden; }
.section-head { background: linear-gradient(135deg, #F5F3FF, #EDE8F9); padding: 12px 16px; display: flex; align-items: center; gap: 10px; }
.section-num { width: 26px; height: 26px; border-radius: 7px; background: var(--cb-purple); color: white; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; flex-shrink: 0; }
.section-title-text { flex: 1; font-size: 14px; font-weight: 700; color: var(--cb-text); }
.section-actions { display: flex; gap: 6px; }
.section-lessons { padding: 12px 16px; background: white; display: flex; flex-direction: column; gap: 8px; }
.lesson-row { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid var(--cb-border); border-radius: 10px; background: #FAFAFA; transition: all .2s; }
.lesson-row:hover { border-color: var(--cb-purple); background: white; }
.lesson-type-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }
.icon-video { background: rgba(59,130,246,.1); color: #3B82F6; }
.icon-article { background: rgba(16,185,129,.1); color: #10B981; }
.icon-quiz { background: rgba(245,158,11,.1); color: #F59E0B; }
.lesson-name { flex: 1; font-size: 13px; font-weight: 600; color: var(--cb-text); }
.lesson-meta { font-size: 11px; color: var(--cb-muted); }
.lesson-actions { display: flex; gap: 5px; }

.add-section-btn { width: 100%; padding: 12px; border: 2px dashed var(--cb-border); border-radius: 12px; background: transparent; color: var(--cb-muted); font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
.add-section-btn:hover { border-color: var(--cb-purple); color: var(--cb-purple); background: rgba(123,111,232,.03); }

/* Modal */
.modal-bg { display: none; position: fixed; inset: 0; background: rgba(26,24,37,.5); backdrop-filter: blur(6px); z-index: 200; align-items: center; justify-content: center; padding: 20px; }
.modal-bg.open { display: flex; }
.modal-box { background: white; border-radius: 20px; padding: 28px; max-width: 520px; width: 100%; box-shadow: 0 24px 80px rgba(26,24,37,.2); }
.modal-title { font-size: 18px; font-weight: 700; color: var(--cb-text); margin-bottom: 4px; }
.modal-sub { font-size: 13px; color: var(--cb-muted); margin-bottom: 20px; }
.modal-actions { display: flex; gap: 10px; margin-top: 20px; justify-content: flex-end; }

/* Syllabus */
.syllabus-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid var(--cb-border); border-radius: 10px; margin-bottom: 8px; background: #FAFAFA; }
.syllabus-item-text { flex: 1; font-size: 14px; color: var(--cb-text); }

/* Stats bar */
.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px; }
.stat-box { background: white; border: 1px solid var(--cb-border); border-radius: 12px; padding: 16px; text-align: center; }
.stat-box-val { font-size: 24px; font-weight: 800; color: var(--cb-purple); font-family: serif; }
.stat-box-label { font-size: 12px; color: var(--cb-muted); margin-top: 4px; }

.alert-success { background: #ECFDF5; border: 1px solid #6EE7B7; border-radius: 10px; padding: 12px 16px; color: #065F46; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.alert-error { background: #FEF2F2; border: 1px solid #FCA5A5; border-radius: 10px; padding: 12px 16px; color: #991B1B; font-size: 13px; margin-bottom: 16px; }
.toggle-wrap { display: flex; align-items: center; gap: 12px; }
.toggle-input { width: 44px; height: 24px; appearance: none; background: #D1D5DB; border-radius: 999px; cursor: pointer; transition: background .2s; position: relative; flex-shrink: 0; }
.toggle-input:checked { background: var(--cb-purple); }
.toggle-input::after { content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; border-radius: 50%; background: white; transition: left .2s; box-shadow: 0 1px 4px rgba(0,0,0,.2); }
.toggle-input:checked::after { left: 22px; }
@media (max-width: 768px) {
    .form-row, .form-row-3 { grid-template-columns: 1fr; }
    .stats-row { grid-template-columns: 1fr 1fr; }
    .cb-tabs { overflow-x: auto; }
}
</style>


<header class="topbar" role="banner">
    <div class="topbar__search">
        <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
        <input type="text" class="topbar__search-input" placeholder="Search..." aria-label="Search">
    </div>
    <div class="topbar__actions">
        <a href="<?php echo e(route('instructor.courses.edit', $course)); ?>" class="btn-outline" style="font-size:12px; padding:8px 14px;">
            <i class="fa-solid fa-pen-to-square"></i> Edit Info
        </a>
    </div>
</header>


<?php if(session('success')): ?>
    <div class="alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e(session('error')); ?></div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="alert-error">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div>• <?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>


<div class="cb-header">
    <div>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
            <a href="<?php echo e(route('instructor.courses.index')); ?>" style="color:rgba(255,255,255,.5);font-size:12px;text-decoration:none;">
                ← My Courses
            </a>
        </div>
        <h1><?php echo e($course->title); ?></h1>
        <p><?php echo e($course->category->name ?? 'No Category'); ?> · <?php echo e(ucfirst($course->difficulty)); ?> · <?php echo e($course->language); ?></p>
    </div>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span class="cb-badge <?php echo e($course->is_published ? 'badge-published' : 'badge-draft'); ?>">
            <i class="fa-solid fa-<?php echo e($course->is_published ? 'eye' : 'eye-slash'); ?>"></i>
            <?php echo e($course->is_published ? 'Published' : 'Draft'); ?>

        </span>
        <?php if($course->is_published): ?>
            <a href="<?php echo e(route('courses.show', $course->slug)); ?>" target="_blank" class="btn-welcome btn-welcome--ghost" style="font-size:12px;padding:7px 14px;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview
            </a>
        <?php endif; ?>
    </div>
</div>


<div class="stats-row">
    <div class="stat-box">
        <div class="stat-box-val"><?php echo e($course->enrollments_count); ?></div>
        <div class="stat-box-label">Students</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-val"><?php echo e($totalLessons); ?></div>
        <div class="stat-box-label">Lessons</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-val"><?php echo e($course->sections->count()); ?></div>
        <div class="stat-box-label">Sections</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-val"><?php echo e(number_format($course->reviews_avg_rating ?? 0, 1)); ?></div>
        <div class="stat-box-label">Avg Rating</div>
    </div>
</div>


<div class="cb-tabs" role="tablist">
    <button class="cb-tab active" onclick="switchTab('curriculum')" id="tab-curriculum">
        <i class="fa-solid fa-list-ol"></i> Curriculum
    </button>
    <button class="cb-tab" onclick="switchTab('syllabus')" id="tab-syllabus">
        <i class="fa-solid fa-lightbulb"></i> What You'll Learn
    </button>
    <button class="cb-tab" onclick="switchTab('overview')" id="tab-overview">
        <i class="fa-solid fa-circle-info"></i> Overview
    </button>
</div>


<div class="cb-panel active" id="panel-curriculum">

    <?php $__currentLoopData = $course->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sIdx => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="section-block" id="section-block-<?php echo e($section->id); ?>">
        <div class="section-head">
            <div class="section-num"><?php echo e($sIdx + 1); ?></div>
            <span class="section-title-text"><?php echo e($section->title); ?></span>
            <span style="font-size:11px;color:var(--cb-muted);margin-right:8px;">
                <?php echo e($section->lessons->count()); ?> lesson<?php echo e($section->lessons->count() != 1 ? 's' : ''); ?>

            </span>
            <div class="section-actions">
                <button class="btn-ghost-sm" onclick="openEditSection(<?php echo e($section->id); ?>, '<?php echo e(addslashes($section->title)); ?>')" title="Rename section">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button class="btn-danger-sm" onclick="openDeleteSection(<?php echo e($section->id); ?>, '<?php echo e(addslashes($section->title)); ?>')" title="Delete section">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>

        <div class="section-lessons" id="lessons-<?php echo e($section->id); ?>">
            <?php $__empty_1 = true; $__currentLoopData = $section->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lIdx => $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="lesson-row" id="lesson-row-<?php echo e($lesson->id); ?>">
                <div class="lesson-type-icon icon-<?php echo e($lesson->type); ?>">
                    <?php if($lesson->type === 'video'): ?> <i class="fa-solid fa-play"></i>
                    <?php elseif($lesson->type === 'quiz'): ?> <i class="fa-solid fa-question"></i>
                    <?php else: ?> <i class="fa-solid fa-file-lines"></i>
                    <?php endif; ?>
                </div>
                <div class="lesson-name"><?php echo e($lesson->title); ?></div>
                <div class="lesson-meta">
                    <?php echo e(ucfirst($lesson->type)); ?>

                    <?php if($lesson->duration_seconds): ?> · <?php echo e(intdiv($lesson->duration_seconds, 60)); ?> min <?php endif; ?>
                    <?php if($lesson->is_free_preview): ?> · <span style="color:var(--cb-teal);">Free</span> <?php endif; ?>
                </div>
                <div class="lesson-actions">
                    <?php if($lesson->type === 'quiz'): ?>
                    <a href="<?php echo e(route('instructor.quizzes.edit', $lesson)); ?>" class="btn-teal-sm" title="Edit quiz">
                        <i class="fa-solid fa-pen"></i> Quiz
                    </a>
                    <?php else: ?>
                    <button class="btn-ghost-sm" onclick="openEditLesson(<?php echo e($lesson->id); ?>, <?php echo e($section->id); ?>, '<?php echo e(addslashes($lesson->title)); ?>', '<?php echo e($lesson->type); ?>', '<?php echo e(addslashes($lesson->video_url ?? '')); ?>', <?php echo e($lesson->duration_seconds ? intdiv($lesson->duration_seconds, 60) : 'null'); ?>, <?php echo e($lesson->is_free_preview ? 'true' : 'false'); ?>)" title="Edit lesson">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <?php endif; ?>
                    <button class="btn-danger-sm" onclick="openDeleteLesson(<?php echo e($lesson->id); ?>, '<?php echo e(addslashes($lesson->title)); ?>')" title="Delete lesson">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="text-align:center;padding:20px;color:var(--cb-muted);font-size:13px;">
                <i class="fa-solid fa-inbox" style="font-size:24px;margin-bottom:8px;display:block;"></i>
                Belum ada lesson. Tambahkan lesson pertama!
            </div>
            <?php endif; ?>

            <button class="add-section-btn" style="margin-top:8px;border-radius:8px;padding:9px;"
                    onclick="openAddLesson(<?php echo e($section->id); ?>)">
                <i class="fa-solid fa-plus"></i> Tambah Lesson
            </button>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <button class="add-section-btn" onclick="openAddSection()">
        <i class="fa-solid fa-plus"></i> Tambah Section / Bab Baru
    </button>
</div>


<div class="cb-panel" id="panel-syllabus">
    <div class="cb-card">
        <div class="cb-card-head">
            <span class="cb-card-title"><i class="fa-solid fa-lightbulb" style="color:var(--cb-gold);"></i> What Students Will Learn</span>
        </div>
        <div class="cb-card-body">
            <p style="font-size:13px;color:var(--cb-muted);margin-bottom:16px;">Tambahkan poin-poin yang akan dipelajari siswa. Gunakan kalimat singkat dan jelas.</p>

            <div id="syllabus-list">
            <?php $__empty_1 = true; $__currentLoopData = $course->syllabus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="syllabus-item" id="syllabus-item-<?php echo e($item->id); ?>">
                    <i class="fa-solid fa-check-circle" style="color:var(--cb-teal);flex-shrink:0;"></i>
                    <span class="syllabus-item-text"><?php echo e($item->item); ?></span>
                    <button class="btn-ghost-sm" onclick="openEditSyllabus(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->item)); ?>')" title="Edit">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button class="btn-danger-sm" onclick="deleteSyllabus(<?php echo e($item->id); ?>)" title="Hapus">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div id="syllabus-empty" style="text-align:center;padding:28px;color:var(--cb-muted);font-size:13px;">
                    <i class="fa-solid fa-lightbulb" style="font-size:28px;margin-bottom:10px;display:block;opacity:.4;"></i>
                    Belum ada item. Tambahkan apa yang akan dipelajari siswa.
                </div>
            <?php endif; ?>
            </div>

            <form action="<?php echo e(route('instructor.syllabus.store', $course)); ?>" method="POST" style="margin-top:16px;display:flex;gap:10px;">
                <?php echo csrf_field(); ?>
                <input type="text" name="item" class="form-control" placeholder="e.g. Memahami konsep dasar machine learning" required style="flex:1;">
                <button type="submit" class="btn-primary" style="white-space:nowrap;">
                    <i class="fa-solid fa-plus"></i> Tambah
                </button>
            </form>
        </div>
    </div>
</div>


<div class="cb-panel" id="panel-overview">
    <div class="cb-card">
        <div class="cb-card-head">
            <span class="cb-card-title"><i class="fa-solid fa-circle-info" style="color:var(--cb-purple);"></i> Informasi Kursus</span>
            <a href="<?php echo e(route('instructor.courses.edit', $course)); ?>" class="btn-primary" style="font-size:12px;padding:8px 14px;">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
        </div>
        <div class="cb-card-body">
            <div class="form-row" style="margin-bottom:16px;">
                <div>
                    <div class="form-label">Judul</div>
                    <div style="font-size:14px;color:var(--cb-text);font-weight:600;"><?php echo e($course->title); ?></div>
                </div>
                <div>
                    <div class="form-label">Kategori</div>
                    <div style="font-size:14px;color:var(--cb-text);"><?php echo e($course->category->name ?? '-'); ?></div>
                </div>
            </div>
            <div class="form-row" style="margin-bottom:16px;">
                <div>
                    <div class="form-label">Harga Kursus</div>
                    <div style="font-size:14px;color:var(--cb-text);"><?php echo e($course->formatted_price); ?></div>
                </div>
                <div>
                    <div class="form-label">Harga Sertifikat</div>
                    <div style="font-size:14px;color:var(--cb-text);"><?php echo e($course->formatted_certificate_price); ?></div>
                </div>
            </div>
            <div class="form-row" style="margin-bottom:16px;">
                <div>
                    <div class="form-label">Difficulty</div>
                    <div style="font-size:14px;color:var(--cb-text);"><?php echo e(ucfirst($course->difficulty)); ?></div>
                </div>
                <div>
                    <div class="form-label">Durasi</div>
                    <div style="font-size:14px;color:var(--cb-text);"><?php echo e($course->duration_weeks); ?> minggu</div>
                </div>
            </div>
            <div class="form-row" style="margin-bottom:16px;">
                <div>
                    <div class="form-label">Bahasa</div>
                    <div style="font-size:14px;color:var(--cb-text);"><?php echo e($course->language); ?></div>
                </div>
                <div>
                    <div class="form-label">Audit Track</div>
                    <div style="font-size:14px;color:var(--cb-text);">
                        <?php if($course->has_audit_track): ?>
                            <span style="color:var(--cb-teal);">✓ Aktif</span>
                            <?php if($course->audit_access_weeks): ?> (<?php echo e($course->audit_access_weeks); ?> minggu) <?php endif; ?>
                        <?php else: ?>
                            <span style="color:var(--cb-muted);">Tidak aktif</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if($course->short_description): ?>
            <div style="margin-bottom:16px;">
                <div class="form-label">Deskripsi Singkat</div>
                <div style="font-size:13px;color:var(--cb-soft);line-height:1.6;"><?php echo e($course->short_description); ?></div>
            </div>
            <?php endif; ?>
            <?php if($course->prerequisites): ?>
            <div>
                <div class="form-label">Prerequisites</div>
                <div style="font-size:13px;color:var(--cb-soft);line-height:1.6;"><?php echo e($course->prerequisites); ?></div>
            </div>
            <?php endif; ?>
            <?php if($course->thumbnail_url): ?>
            <div style="margin-top:16px;">
                <div class="form-label">Thumbnail</div>
                <img src="<?php echo e($course->thumbnail_url); ?>" alt="thumbnail" style="width:100%;max-width:300px;border-radius:10px;border:1px solid var(--cb-border);">
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>




<div class="modal-bg" id="modal-add-section">
    <div class="modal-box">
        <div class="modal-title">Tambah Section / Bab</div>
        <div class="modal-sub">Bab baru akan ditambahkan di akhir kursus.</div>
        <form method="POST" action="<?php echo e(route('instructor.sections.store', $course)); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Judul Section *</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Bab 1: Pengantar Machine Learning" required autofocus>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modal-add-section')">Batal</button>
                <button type="submit" class="btn-primary"><i class="fa-solid fa-plus"></i> Tambah Section</button>
            </div>
        </form>
    </div>
</div>


<div class="modal-bg" id="modal-edit-section">
    <div class="modal-box">
        <div class="modal-title">Rename Section</div>
        <div class="modal-sub">Ubah nama section / bab ini.</div>
        <form method="POST" id="form-edit-section">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label class="form-label">Judul Section *</label>
                <input type="text" name="title" id="edit-section-title" class="form-control" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modal-edit-section')">Batal</button>
                <button type="submit" class="btn-primary"><i class="fa-solid fa-check"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>


<div class="modal-bg" id="modal-delete-section">
    <div class="modal-box">
        <div style="width:48px;height:48px;border-radius:12px;background:#FFF0F0;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--cb-red);margin-bottom:14px;">
            <i class="fa-solid fa-trash"></i>
        </div>
        <div class="modal-title">Hapus Section?</div>
        <div class="modal-sub">Section "<strong id="delete-section-name"></strong>" dan semua lesson di dalamnya akan dihapus permanen.</div>
        <form method="POST" id="form-delete-section">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modal-delete-section')">Batal</button>
                <button type="submit" style="background:var(--cb-red);color:white;border:none;padding:10px 20px;border-radius:999px;font-size:13px;font-weight:700;cursor:pointer;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>


<div class="modal-bg" id="modal-add-lesson">
    <div class="modal-box" style="max-width:580px;">
        <div class="modal-title">Tambah Lesson</div>
        <div class="modal-sub">Isi detail lesson yang ingin ditambahkan ke section ini.</div>
        <form method="POST" id="form-add-lesson">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Judul Lesson *</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Pengenalan Konsep Neural Network" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tipe *</label>
                    <select name="type" class="form-control" id="add-lesson-type" onchange="toggleVideoField('add')">
                        <option value="video">🎬 Video</option>
                        <option value="article">📄 Article</option>
                        <option value="quiz">📝 Quiz</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" name="duration_minutes" class="form-control" placeholder="15" min="1" max="600">
                </div>
            </div>
            <div class="form-group" id="add-video-url-group">
                <label class="form-label">Video URL (YouTube)</label>
                <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <div class="form-group">
                <label class="form-label">Konten / Deskripsi</label>
                <textarea name="content" class="form-control" rows="3" placeholder="Deskripsi singkat atau konten artikel..."></textarea>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <input type="checkbox" name="is_free_preview" value="1" id="add-free-preview" style="width:16px;height:16px;accent-color:var(--cb-teal);">
                <label for="add-free-preview" style="font-size:13px;color:var(--cb-soft);cursor:pointer;">Lesson ini gratis (free preview)</label>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modal-add-lesson')">Batal</button>
                <button type="submit" class="btn-primary"><i class="fa-solid fa-plus"></i> Tambah Lesson</button>
            </div>
        </form>
    </div>
</div>


<div class="modal-bg" id="modal-edit-lesson">
    <div class="modal-box" style="max-width:580px;">
        <div class="modal-title">Edit Lesson</div>
        <div class="modal-sub">Perbarui informasi lesson ini.</div>
        <form method="POST" id="form-edit-lesson">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label class="form-label">Judul Lesson *</label>
                <input type="text" name="title" id="edit-lesson-title" class="form-control" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tipe *</label>
                    <select name="type" class="form-control" id="edit-lesson-type" onchange="toggleVideoField('edit')">
                        <option value="video">🎬 Video</option>
                        <option value="article">📄 Article</option>
                        <option value="quiz">📝 Quiz</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" name="duration_minutes" id="edit-lesson-duration" class="form-control" min="1" max="600">
                </div>
            </div>
            <div class="form-group" id="edit-video-url-group">
                <label class="form-label">Video URL (YouTube)</label>
                <input type="url" name="video_url" id="edit-lesson-video" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <div class="form-group">
                <label class="form-label">Konten / Deskripsi</label>
                <textarea name="content" id="edit-lesson-content" class="form-control" rows="3"></textarea>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <input type="checkbox" name="is_free_preview" value="1" id="edit-free-preview" style="width:16px;height:16px;accent-color:var(--cb-teal);">
                <label for="edit-free-preview" style="font-size:13px;color:var(--cb-soft);cursor:pointer;">Lesson ini gratis (free preview)</label>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modal-edit-lesson')">Batal</button>
                <button type="submit" class="btn-primary"><i class="fa-solid fa-check"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>


<div class="modal-bg" id="modal-delete-lesson">
    <div class="modal-box">
        <div style="width:48px;height:48px;border-radius:12px;background:#FFF0F0;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--cb-red);margin-bottom:14px;">
            <i class="fa-solid fa-trash"></i>
        </div>
        <div class="modal-title">Hapus Lesson?</div>
        <div class="modal-sub">Lesson "<strong id="delete-lesson-name"></strong>" akan dihapus permanen.</div>
        <form method="POST" id="form-delete-lesson">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modal-delete-lesson')">Batal</button>
                <button type="submit" style="background:var(--cb-red);color:white;border:none;padding:10px 20px;border-radius:999px;font-size:13px;font-weight:700;cursor:pointer;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>


<div class="modal-bg" id="modal-edit-syllabus">
    <div class="modal-box">
        <div class="modal-title">Edit Item Syllabus</div>
        <form method="POST" id="form-edit-syllabus">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-group" style="margin-top:14px;">
                <label class="form-label">Item *</label>
                <input type="text" name="item" id="edit-syllabus-item" class="form-control" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modal-edit-syllabus')">Batal</button>
                <button type="submit" class="btn-primary"><i class="fa-solid fa-check"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
// ── Tab Switching ───────────────────────────────────────────────
function switchTab(tab) {
    document.querySelectorAll('.cb-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.cb-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    document.getElementById('panel-' + tab).classList.add('active');
}

// ── Modal Helpers ───────────────────────────────────────────────
function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-bg').forEach(m => {
    m.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
});

// ── Section Modals ──────────────────────────────────────────────
function openAddSection() { openModal('modal-add-section'); }

function openEditSection(id, title) {
    document.getElementById('edit-section-title').value = title;
    document.getElementById('form-edit-section').action = '<?php echo e(url("instructor/sections")); ?>/' + id;
    openModal('modal-edit-section');
}

function openDeleteSection(id, title) {
    document.getElementById('delete-section-name').textContent = title;
    document.getElementById('form-delete-section').action = '<?php echo e(url("instructor/sections")); ?>/' + id;
    openModal('modal-delete-section');
}

// ── Lesson Modals ───────────────────────────────────────────────
function openAddLesson(sectionId) {
    document.getElementById('form-add-lesson').action = '<?php echo e(url("instructor/sections")); ?>/' + sectionId + '/lessons';
    // Reset form
    document.getElementById('form-add-lesson').reset();
    document.getElementById('add-video-url-group').style.display = 'block';
    openModal('modal-add-lesson');
}

function openEditLesson(lessonId, sectionId, title, type, videoUrl, durationMin, isFreePreview) {
    document.getElementById('form-edit-lesson').action = '<?php echo e(url("instructor/lessons")); ?>/' + lessonId;
    document.getElementById('edit-lesson-title').value = title;
    document.getElementById('edit-lesson-type').value = type;
    document.getElementById('edit-lesson-video').value = videoUrl || '';
    document.getElementById('edit-lesson-duration').value = durationMin || '';
    document.getElementById('edit-free-preview').checked = isFreePreview;
    toggleVideoField('edit');
    openModal('modal-edit-lesson');
}

function openDeleteLesson(id, title) {
    document.getElementById('delete-lesson-name').textContent = title;
    document.getElementById('form-delete-lesson').action = '<?php echo e(url("instructor/lessons")); ?>/' + id;
    openModal('modal-delete-lesson');
}

function toggleVideoField(prefix) {
    const type = document.getElementById(prefix + '-lesson-type').value;
    const group = document.getElementById(prefix + '-video-url-group');
    group.style.display = (type === 'video') ? 'block' : 'none';
}

// ── Syllabus ────────────────────────────────────────────────────
function openEditSyllabus(id, item) {
    document.getElementById('edit-syllabus-item').value = item;
    document.getElementById('form-edit-syllabus').action = '<?php echo e(url("instructor/syllabus")); ?>/' + id;
    openModal('modal-edit-syllabus');
}

function deleteSyllabus(id) {
    if (!confirm('Hapus item ini?')) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo e(url("instructor/syllabus")); ?>/' + id;
    form.innerHTML = `
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        <input type="hidden" name="_method" value="DELETE">
    `;
    document.body.appendChild(form);
    form.submit();
}

// ── Esc key closes modals ───────────────────────────────────────
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-bg.open').forEach(m => m.classList.remove('open'));
    }
});

// ── Auto-open tab dari URL hash ─────────────────────────────────
const hash = window.location.hash;
if (hash === '#syllabus') switchTab('syllabus');
else if (hash === '#overview') switchTab('overview');
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.instructor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\coursify\resources\views/instructor/courses/show.blade.php ENDPATH**/ ?>