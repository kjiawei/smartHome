# -*- mode: python -*-

block_cipher = None


a = Analysis(['login.py'],
             pathex=['C:\\Users\\keji01\\AppData\\Local\\Programs\\Python\\Python36-32\\Lib\\site-packages\\PyQt5\\Qt\\bin', 'C:\\Users\\keji01\\AppData\\Local\\Programs\\Python\\Python36-32\\Lib\\site-packages\\PyQt5\\Qt\\plugins', 'E:\\python\\PyQt\\music_download'],
             binaries=[],
             datas=[],
             hiddenimports=['pkg_resources'],
             hookspath=[],
             runtime_hooks=[],
             excludes=[],
             win_no_prefer_redirects=False,
             win_private_assemblies=False,
             cipher=block_cipher)
pyz = PYZ(a.pure, a.zipped_data,
             cipher=block_cipher)
exe = EXE(pyz,
          a.scripts,
          a.binaries,
          a.zipfiles,
          a.datas,
          name='login',
          debug=False,
          strip=False,
          upx=True,
          runtime_tmpdir=None,
          console=False )
